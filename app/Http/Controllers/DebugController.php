<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Mailer\SendMail;
use Exception;
use Mail;
use App;

class DebugController extends Controller
{
    public function debug()
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
