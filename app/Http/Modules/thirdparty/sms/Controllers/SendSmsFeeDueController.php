<?php

namespace App\Http\Modules\thirdparty\sms\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\thirdparty\sms\Models\SendSmsFeeDue;
use App\Http\CSVGenerator\CSV;

class SendSmsFeeDueController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . SendSmsFeeDue::staticScreenId());
    }

    public function feeDue(Request $request)
    {
        $sms = new SendSmsFeeDue($request->input());
        return view('thirdparty.sms.SendSms.fee-due', compact('sms'));
    }

    public function sendFeeDue(Request $request)
    {
        $this->validate($request, ['student_ids' => 'required|string']);
        $sms = new SendSmsFeeDue($request->input());
        flash('Fee Due SMS Sent!');
        return $this->sendSmsToStudents($sms, $request->input('student_ids'));
    }

    public function feeDueCSV(Request $request)
    {
        $sms = new SendSmsFeeDue($request->input());

        $header = ['Account', 'Mobile', 'SMS Text'];
        $rows = [];

        foreach ($sms->rows() as $row) {
            $rowData = [
                $row['account_name'],
                phone_number($row['mobile_phone']),
                'Your current fee due amount is ' . amount($row['due_amount']),
            ];

            $rows[] = $rowData;
        }

        return CSV::make($header, $rows);
    }
}
