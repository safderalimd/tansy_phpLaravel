<?php

namespace App\Http\SMS;

use App\Http\SMS\Providers\Provider;

/**
 * Holds SMS business logic for the application.
 */
class Sender
{
    protected $provider;

    public function __construct(Provider $provider)
    {
        $this->provider = $provider;
    }

    public function forgotPasswordOTP($phone, $message)
    {
        $this->provider->forgotPasswordOTP($phone, $message);
    }
}
