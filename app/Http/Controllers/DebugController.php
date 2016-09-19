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
        $phone = '8801933344';
        $message = "Dear Customer, we have received a request to reset your password for user name sysadmin@release2m3 on 19-Sep-2016 15:32:03. Your OTP will be valid for next 10mins and your OTP is 12345678.";

        SMS::otp()->forgotPasswordOTP($phone, $message);

        d('---');
    }

    public function oldDebugSMS()
    {
        try {

            $model = new SendSmsModel;
            $api = $model->smsCredentials();
            if ($api['active'] != 1) {
                return dd($api);
            }

            d($api);

            $sender = new SmsSender($api['username'], $api['hash'], $api['senderId']);
            d($sender);

            $balance = $sender->getBalance();
            dd($balance);

        } catch (Exception $e) {
            dd($e);
        }

        dd('--');

        // // curl --data "username=md.salmancse@gmail.com&hash=be80f85f7139ac89623c35cd6f25316261148dda" http://api.textlocal.in/balance/

        // // Textlocal account details
        // $username = "md.salmancse@gmail.com";
        // $hash = "be80f85f7139ac89623c35cd6f25316261148dda";

        // // Prepare data for POST request
        // $data = array('username' => $username, 'hash' => $hash);
        // d($data);

        // // Send the POST request with cURL
        // $ch = curl_init('http://api.textlocal.in/balance/');

        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_HEADER, true);

        // $response = curl_exec($ch);

        // // Process your response here
        // d(curl_getinfo($ch));
        // d($response);

        // curl_close($ch);

        // die();
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
