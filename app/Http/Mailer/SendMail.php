<?php

namespace App\Http\Mailer;

use Mail;
use Exception;
use App;

class SendMail
{
    public static function exception(Exception $exception)
    {
        try {

            if (App::environment('local')) {
                return;
            }

            $env = App::environment();
            $env = strtoupper($env);

            // send mail to product owner
            Mail::send('emails.exception', ['exception' => $exception], function ($m) use ($env) {
                $m->to('safderalimd@outlook.com', 'Admin');
                $m->subject("TansyCloud {$env} Error Message!");
            });

            // send mail to developer admin
            $admin = env('ADMIN_EMAIL');
            if ($admin) {
                Mail::send('emails.exception', ['exception' => $exception], function ($m) use ($admin, $env) {
                    $m->to($admin, 'Admin');
                    $m->subject("TansyCloud {$env} Error Message!");
                });
            }


        } catch (Exception $e) {

        }
    }
}
