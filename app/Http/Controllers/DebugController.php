<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Mailer\SendMail;
use Exception;
use App\Http\Modules\thirdparty\sms\Models\SendSmsModel;
use App\Http\Modules\thirdparty\sms\SmsSender;

class DebugController extends Controller
{
    public function debugException()
    {
        throw new Exception("Debug test error exception.");
    }

    public function debugSMS()
    {
        try {

            $model = new SendSmsModel;
            $api = $model->smsCredentials();
            d($api);

            $sender = new SmsSender($api['username'], $api['hash'], $api['senderId']);
            d($sender);

            $balance = $sender->getBalance();
            dd($balance);

        } catch (Exception $e) {
            dd($e);
        }
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
