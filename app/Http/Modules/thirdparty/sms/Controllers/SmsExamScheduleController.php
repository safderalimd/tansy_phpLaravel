<?php

namespace App\Http\Modules\thirdparty\sms\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\thirdparty\sms\Models\SendSmsExamSchedule;
use App\Http\CSVGenerator\CSV;

class SmsExamScheduleController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . SendSmsExamSchedule::staticScreenId());
    }

    public function examSchedule(Request $request)
    {
        $sms = new SendSmsExamSchedule($request->input());
        return view('thirdparty.sms.SendSms.exam-schedule', compact('sms'));
    }

    public function sendExamSchedule(Request $request)
    {
        $this->validate($request, ['student_ids' => 'required|string']);
        $sms = new SendSmsExamSchedule($request->input());
        flash('Exam Schedule SMS Sent!');
        return $this->sendSmsToStudents($sms, $request->input('student_ids'));
    }

    public function examScheduleCSV(Request $request)
    {
        $sms = new SendSmsExamSchedule($request->input());

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
