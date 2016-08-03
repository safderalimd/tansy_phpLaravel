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

            if (App::environment('production')) {
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

    public static function receipt($email, $receipt)
    {
        try {

            $email = trim($email);
            $name = isset($receipt->header['paid_by_name']) ? $receipt->header['paid_by_name'] : 'Receipt';
            $schoolName = isset($receipt->schoolName) ? $receipt->schoolName : 'School';

            Mail::send('emails.receipt', ['receipt' => $receipt], function ($m) use ($email, $name, $schoolName) {
                $m->from(config('mail.from.address'), $schoolName);
                $m->to($email, $name);
                $m->subject($schoolName . ' Receipt');
            });

        } catch (Exception $e) {

        }
    }
}
