<?php

namespace App\Http\Modules\thirdparty\sms\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\thirdparty\sms\Models\SendSmsAttendance;

class SendSmsAttendanceController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . SendSmsAttendance::staticScreenId());
    }

    public function attendence(Request $request)
    {
        $sms = new SendSmsAttendance($request->input());
        return view('thirdparty.sms.SendSms.attendance', compact('sms'));
    }

    public function sendAttendance(Request $request)
    {
        $this->validate($request, ['student_ids' => 'required|string']);
        $this->validate($request, ['hidden_absense_date' => 'required|string|max:20']);
        $sms = new SendSmsAttendance($request->input());
        flash('Attendance SMS Sent!');
        return $this->sendSmsToStudents($sms, $request->input('student_ids'));
    }
}
