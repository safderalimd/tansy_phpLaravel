<?php

namespace App\Http\Mailer;

use Mail;
use Exception;
use App;

class SendMail
{
    public static function exception(Exception $exception)
    {
        if (! App::environment('production')) {
            return;
        }

        try {

            Mail::send('emails.exception', ['exception' => $exception], function ($m) {
                $m->from('no-reply@example.org', 'tansycloud');
                $m->to('ludovic_tm@yahoo.com', 'Admin')->subject('TansyCloud Error Message!');
            });

        } catch (Exception $e) {

        }
    }
}
