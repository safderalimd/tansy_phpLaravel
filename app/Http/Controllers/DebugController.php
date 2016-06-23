<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use Mail;

class DebugController extends Controller
{
    public function mail()
    {
        Mail::send([], [], function ($m) {
            $m->from('no-reply@tansycloud.dev', 'tansycloud');
            $m->to('ludovic_tm@yahoo.com', 'Adam')->subject('Error Message!');
            $m->setBody('error messsage content');
        });
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
