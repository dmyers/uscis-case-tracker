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
    public function __invoke(Request $request, $caseNumber)
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

        return response($case);
    }
}
