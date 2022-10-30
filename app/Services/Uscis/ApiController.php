<?php

namespace App\Services\Uscis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * Get the case info from USCIS using API service.
     *
     * @param  Request  $request
     * @param  string  $caseNumber
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(Request $request, $caseNumber = null)
    {
        $data = compact('caseNumber');

        $rules = [
            'caseNumber' => [
                'required', 'string', 'size:13',
                'alpha_start:3', 'numeric_end:10',
            ],
        ];

        $messages = [
            'alpha_start' => 'The :attribute must start with 3 letters.',
            'numeric_end' => 'The :attribute must end with 10 numbers.',
        ];

        validator($data, $rules, $messages)->validate();

        $uscis = app('uscis');
        $case = $uscis->getCaseInfo($caseNumber);

        if ($case['status'] === 'Card Was Delivered To Me By The Post Office') {
            $case['status'] = 'Card Delivered';
        } else if ($case['status'] === 'Case is Ready to Be Scheduled for An Interview') {
            $case['status'] = 'Scheduling Interview';
            $case['status_code'] = 'pending';
        } else if ($case['status'] === 'Case Was Received') {
            $case['status'] = 'Case Received';
        } else if ($case['status'] === 'Case Was Received and A Receipt Notice Was Sent') {
            $case['status'] = 'Case Received Notice Sent';
        } else if ($case['status'] === 'Case Was Approved') {
            $case['status'] = 'Case Approved';
        } else if ($case['status'] === 'Fingerprint Review Was Completed') {
            $case['status'] = 'Fingerprint Completed';
            $case['status_code'] = 'pending';
        } else if ($case['status'] === 'Case Was Updated To Show Fingerprints Were Taken') {
            $case['status'] = 'Fingerprints Taken';
            $case['status_code'] = 'pending';
        }

        if (empty($case['status_code'])) {
            if (strpos(strtolower($case['title']), 'received') !== false) {
                $case['status_code'] = 'pending';
            } else if (strpos(strtolower($case['title']), 'denied') !== false) {
                $case['status_code'] = 'failed';
            } else if (strpos(strtolower($case['title']), 'rejected') !== false) {
                $case['status_code'] = 'failed';
            } else if (strpos(strtolower($case['title']), 'updated') !== false) {
                $case['status_code'] = 'complete';
            } else if (strpos(strtolower($case['title']), 'approved') !== false) {
                $case['status_code'] = 'complete';
            } else if (strpos(strtolower($case['title']), 'completed') !== false) {
                $case['status_code'] = 'complete';
            } else if (strpos(strtolower($case['title']), 'delivered') !== false) {
                $case['status_code'] = 'complete';
            } else {
                $case['status_code'] = 'unknown';
            }
        }

        return response($case);
    }
}
