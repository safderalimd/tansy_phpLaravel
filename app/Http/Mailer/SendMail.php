<?php

namespace App\Http\Mailer;

use Mail;
use Exception;
use App;

class SendMail
{
    public static function exception(Exception $exception)
    {
        if (App::environment('local')) {
            return;
        }

        $admin = env('ADMIN_EMAIL');
        if (! $admin) {
            return;
        }

        $env = App::environment();
        $env = strtoupper($env);

        try {

            Mail::send('emails.exception', ['exception' => $exception], function ($m) use ($admin, $env) {
                $m->to($admin, 'Admin');
                $m->subject("TansyCloud {$env} Error Message!");
            });

        } catch (Exception $e) {

        }
    }
}
