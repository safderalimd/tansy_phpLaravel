<?php

namespace App\Http\SMS;

use Exception;

/**
 * Holds SMS business logic for the application.
 */
class Sender
{
    protected $provider;

    protected $isActive;

    public function __construct($provider, $isActive)
    {
        $this->provider = $provider;
        $this->isActive = $isActive;
    }

    public function inactiveMessage()
    {
        if (! $this->isActive) {
            return 'SMS ACCOUNT IN-ACTIVE.';
        }

        if (is_null($this->provider)) {
            return 'Invalid SMS Provider account.';
        }

        return 'Inactive SMS account. Please contact system admin.';
    }

    public function isActive()
    {
        if ($this->isActive && $this->provider) {
            return true;
        }

        return false;
    }

    public function balance()
    {
        try {
            return ($this->provider) ? $this->provider->getBalance() : 0;
        } catch (Exception $e) {
            return 0;
        }
    }

    public function forgotPasswordOTP($phone, $message)
    {
        if ($this->provider) {
            return $this->provider->forgotPasswordOTP($phone, $message);
        }
    }

    public function changePassword($phone, $message)
    {
        if ($this->provider) {
            return $this->provider->changePassword($phone, $message);
        }
    }

    public function loginOTP($phone, $message)
    {
        if ($this->provider) {
            return $this->provider->loginOTP($phone, $message);
        }
    }

    public function loginSMS($phone, $message)
    {
        if ($this->provider) {
            return $this->provider->loginSMS($phone, $message);
        }
    }

    public function paymentReceipt($phone, $message)
    {
        if ($this->provider) {
            return $this->provider->paymentReceipt($phone, $message);
        }
    }
}
