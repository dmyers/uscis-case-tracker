<?php

namespace App\Services\Uscis;

use PHPHtmlParser\Dom;
use Goutte\Client as Goutte;
use InvalidArgumentException;
use GuzzleHttp\Client as Guzzle;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\DomCrawler\Crawler;

/**
 * USCIS API service.
 *
 * @see Receipt Creator - https://github.com/upretip/uscis/blob/master/uscis/__init__.py
 * @see Neighbor Check - https://github.com/ibot1/uscis_check_neighbors/blob/master/uscis_check_neighbors.py
 * @see https://github.com/japrehm/uscis-case-tracker/blob/4db185153cb127548f2003ef0f340c47481633ea/app/Jobs/ScrapeUSCISJob.php
 */
class UscisApi
{
    /**
     * The Guzzle client instance.
     *
     * @var \Guzzle\Client
     */
    protected $client;

    /** @var string */
    protected const BASE_URL = 'https://egov.uscis.gov';

    /** @var string */
    protected const CASE_API = 'https://egov.uscis.gov/casestatus/mycasestatus.do';

    /**
     * Create a new Uscis service instance.
     *
     * @param  \Guzzle\Client  $client
     * @return void
     */
    public function __construct(Guzzle $client)
    {
        $this->client = $client;
    }

    /**
     * Get the current information for a case.
     *
     * @param  string  $caseNumber
     * @return array
     */
    public function getCaseInfo(string $caseNumber)
    {
        $caseNumber = strtoupper($caseNumber);
        $caseNumber = str_replace('-', '', $caseNumber);
        if (!$this->validateCaseNumber($caseNumber)) {
            throw new InvalidArgumentException('Invalid USCIS case number given.');
        }

        $body = Cache::remember('uscis.cases.'.$caseNumber, now()->addDay(), function () use ($caseNumber) {
            $response = $this->client->post(self::CASE_API, [
                'headers'     => [
                    'Origin'  => self::BASE_URL,
                    'Referer' => 'https://egov.uscis.gov/casestatus/landing.do',
                ],
                'form_params' => [
                    'changeLocale'  => '',
                    'completedActionsCurrentPage' => '',
                    'upcomingActionsCurrentPage'  => '',
                    'appReceiptNum' => $caseNumber,
                    'caseStatusSearchBtn' => 'CHECK STATUS',
                ],
            ]);

            return (string) $response->getBody();
        });

        /** @var \PHPHtmlParser\Dom\Collection */
        $dom = new Dom();
        $dom->loadStr($body);

        $status = trim($dom->find('.current-status-sec')->text());
        $title = $dom->find('.appointment-sec h1')->innerHtml();
        $details = $dom->find('.appointment-sec p')->innerHtml();

        $tracking = TrackingParser::find($details);
        $date = DateParser::find($details);
        $details = strip_tags($details);

        return compact(
            'caseNumber', 'date', 'tracking',
            'status', 'title', 'details'
        );
    }

    /**
     * Validate a case number matches the required format per USCIS.
     *
     * @see https://egov.uscis.gov/casestatus/mycasestatus.do
     * @param  string  $caseNumber
     * @return bool
     */
    public function validateCaseNumber(string $caseNumber): bool
    {
        if (strlen($caseNumber) !== 13) {
            return false;
        }

        return true;
    }
}
