<?php

namespace App\Http\Modules\thirdparty\sms\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\thirdparty\sms\Models\SendSmsHomework;

class SmsHomeworkController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . SendSmsHomework::staticScreenId());
    }

    public function attendence(Request $request)
    {
        $sms = new SendSmsHomework($request->input());
        return view('thirdparty.sms.SendSms.homework', compact('sms'));
    }

    public function sendHomework(Request $request)
    {
        $this->validate($request, ['student_ids' => 'required|string']);
        $this->validate($request, ['hidden_homework_date' => 'required|string|max:20']);
        $sms = new SendSmsHomework($request->input());
        flash('Homework SMS Sent!');
        return $this->sendSmsToStudents($sms, $request->input('student_ids'));
    }
}
