<?php

namespace App\Http\ForgotPassword;

use App\Http\Models\ForgotPassword;
use App\Http\Models\MasterDB;
use Session;

trait OTPThrottle
{
    protected function otpExpiredMessage()
    {
        return 'The OTP has expired.';
    }

    protected function otpPasswordExpiredMessage()
    {
        return 'Password reset time has expired. The next time change the password in 10 minutes.';
    }

    protected function errorMasterDB()
    {
        return 'There is an error with your session. Please try again.';
    }

    public function otpMaxAttempts()
    {
        return 2;
    }

    protected function otpLockedOut()
    {
        if ($this->getOTPAttempts() >= $this->otpMaxAttempts()) {
            return true;
        }

        return false;
    }

    protected function getOTPAttempts()
    {
        $attempts = Session::get('forgot_passwd.otp_attempts');
        return !is_null($attempts) ? $attempts : 0;
    }

    protected function incrementOTPAttempts()
    {
        $attempts = $this->getOTPAttempts() + 1;
        Session::put('forgot_passwd.otp_attempts', $attempts);
    }

    public function remainingOTPTries()
    {
        $remaining = $this->otpMaxAttempts() - $this->getOTPAttempts();
        return ($remaining > 0) ? $remaining : 0;
    }

    public function remainingOTPTriesMessage()
    {
        $remaining = $this->remainingOTPTries();
        $remaining .= ($remaining == 1) ? ' attempt' : ' attempts';
        return 'Wrong OTP. You have '.$remaining.' left.';
    }

    protected function otpLockedOutMessage()
    {
        return 'Too many wrong OPT attempts. Please try again.';
    }

    protected function getNotAllowedMessage()
    {
        return 'Not allowed to use this feature, please contact system admin.';
    }
}
