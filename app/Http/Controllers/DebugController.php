<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Mailer\SendMail;
use Exception;

class DebugController extends Controller
{
    public function debug()
    {
        throw new Exception("Debug test error exception.");
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
