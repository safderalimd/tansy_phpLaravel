<?php

namespace App\Http\Models;

use App\Http\Models\Model;
use Device;
use Session;
use Illuminate\Support\Str;

class ForgotPassword extends Model
{
    protected $screenId = null;

    protected $repositoryNamespace = 'App\Http\Repositories\ForgotPasswordRepository';

    public $loginName;

    public $domain;

    public $otpCode;

    public function validateForgotPassword()
    {
        $this->loginName = head(explode('@', $this->login_field));
        $this->domain = last(explode('@', $this->login_field));

        $this->setAttribute('login_name', $this->loginName);
        $this->setAttribute('user_mobile', $this->mobile_phone);
        $this->setAttribute('ipaddress', userIp());
        $this->setAttribute('login_media', Device::type());
        return $this->repository->validateForgotPassword($this);
    }

    public function userCanResetPassword()
    {
        return $this->verified_user == 1;
    }

    // public function updatePassword()
    // {
    //     $this->setAttribute('ignore_old_password', 1);
    //     return $this->repository->update($this);
    // }

    public function activateOTPSession()
    {
        $this->otpCode = $this->generateOTPCode();

        Session::put('forgot_passwd.otp_active', true);
        Session::put('forgot_passwd.otp_value', $this->otpCode);
        Session::put('forgot_passwd.otp_created_at', time());
        Session::put('forgot_passwd.domain', $this->domain);
        Session::put('forgot_passwd.login_name', $this->loginName);
        Session::put('forgot_passwd.mobile_phone', $this->mobile_phone);
        Session::put('forgot_passwd.user_id', $this->user_id);
    }

    public function getOTPMessage()
    {
        $name = $this->getOTPLoginUsername();
        $startTime = $this->getOPTStartTimeFormatted();
        $otp = $this->getOPTCode();
        return "Dear Customer, we have received a request to reset your password for user name {$name} on {$startTime}. Your OTP will be valid for next 10mins and your OTP is {$otp}.";
    }

    public function getOTPLoginUsername()
    {
        $domain = Session::get('forgot_passwd.domain');
        $loginName = Session::get('forgot_passwd.login_name');
        return $loginName . '@' . $domain;
    }

    public function getOPTStartTimeFormatted()
    {
        $time = $this->getOPTStartTime();
        return date("d-M-Y H:m:s", $time);
    }

    public function getOPTStartTime()
    {
        return Session::get('forgot_passwd.otp_created_at');
    }

    public function getOPTCode()
    {
        return Session::get('forgot_passwd.otp_value');
    }

    public function getOTPUserMobile()
    {
        return Session::get('forgot_passwd.mobile_phone');
    }

    public function otpSessionIsActive()
    {
        return Session::get('forgot_passwd.otp_active') == true;
    }

    public function otpStillValid()
    {
        return $this->otpSecondsRemainingValid() > 0 ? true : false;
    }

    public function otpSecondsRemainingValid()
    {
        $startTime = $this->getOPTStartTime();
        return time() - $startTime;
    }

    /**
     * Generate 8 digit alpha-numeric code
     *
     * @return string
     */
    public function generateOTPCode()
    {
        return Str::quickRandom(8);
    }
}
