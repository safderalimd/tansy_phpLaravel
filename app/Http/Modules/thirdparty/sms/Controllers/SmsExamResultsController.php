<?php

namespace App\Http\Modules\thirdparty\sms\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\thirdparty\sms\Models\SendSmsExamResults;
use App\Http\CSVGenerator\CSV;

class SmsExamResultsController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . SendSmsExamResults::staticScreenId());
    }

    public function examResults(Request $request)
    {
        $sms = new SendSmsExamResults($request->input());
        return view('thirdparty.sms.SendSms.exam-results', compact('sms'));
    }

    public function sendExamResults(Request $request)
    {
        $this->validate($request, ['student_ids' => 'required|string']);
        $sms = new SendSmsExamResults($request->input());
        flash('Exam Results SMS Sent!');
        return $this->sendSmsToStudents($sms, $request->input('student_ids'));
    }

    public function examResultsCSV(Request $request)
    {
        $sms = new SendSmsExamResults($request->input());

        $header = ['Account', 'Mobile', 'SMS Text'];
        $rows = [];

        foreach ($sms->rows() as $row) {
            $rowData = [
                $row['account_name'],
                phone_number($row['mobile_phone']),
                $row['sms_text'],
            ];

            $rows[] = $rowData;
        }

        return CSV::make($header, $rows);
    }
}
