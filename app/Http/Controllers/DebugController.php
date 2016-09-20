<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Mailer\SendMail;
use Exception;
use Mail;
use SMS;

class DebugController extends Controller
{
    public function debugSMS()
    {
        d(SMS::transactional()->paymentReceipt('83434','test',3,4,5));
        d(SMS::transactional()->isActive());
        d(SMS::transactional()->balance());


        // $phone = '8801933344';
        // $message = "Dear Customer, we have received a request to reset your password for user name sysadmin@release2m3 on 19-Sep-2016 15:32:03. Your OTP will be valid for next 10mins and your OTP is 12345678.";

        // SMS::otp()->forgotPasswordOTP($phone, $message);

        // d('---');
    }

    public function debugException()
    {
        // send mail to developer admin
        $admin = env('ADMIN_EMAIL');
        $exception = new Exception('test');
        if ($admin) {
            Mail::send('emails.exception', ['exception' => $exception], function ($m) use ($admin) {
                $m->to($admin, 'Admin');
                $m->subject("TansyCloud TEST Error Message!");
            });
        }
        // throw new Exception("Debug test error exception.");
    }

    public function phpinfo()
    {
        phpinfo();
    }

    public function enableDebugbar()
    {
        $response = new Response('Debugbar Enabled!');
        $response->withCookie('enable_debugbar', '1', 10000);
        return $response;
    }
}
