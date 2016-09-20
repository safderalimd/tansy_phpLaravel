<?php

namespace App\Http\Models;

use App\Http\Models\Model;
use Device;
use Session;
use Illuminate\Support\Str;
use App\Http\Traits\ChangePasswordMessage;

class ForgotPassword extends Model
{
    protected $screenId = null;

    protected $repositoryNamespace = 'App\Http\Repositories\ForgotPasswordRepository';

    use ChangePasswordMessage;

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

    public function sendChangePasswordSMS()
    {
        return $this->send_change_password_sms == 1;
    }

    public function resetPassword()
    {
        Session::put('forgot_passwd.otp_validated_at', 0);

        $this->setAttribute('old_password', null);
        $this->setAttribute('new_password', $this->new_password);
        $this->setAttribute('ignore_old_password', 1);
        $this->setAttribute('session_id', -1);
        $this->setAttribute('user_id', $this->getOTPUserId());
        $this->setAttribute('screen_id', -1);
        $this->setAttribute('debug_sproc', -1);
        $this->setAttribute('audit_screen_visit', -1);

        return $this->repository->changePassword($this);
    }

    public function validOTP($otp)
    {
        $otp = trim($otp);
        return $otp == $this->getOPTCode();
    }

    public function activateOTPSession()
    {
        $this->otpCode = $this->generateOTPCode();

        Session::put('forgot_passwd.otp_value', $this->otpCode);
        Session::put('forgot_passwd.otp_created_at', time());
        Session::put('forgot_passwd.otp_validated_at', 0);
        Session::put('forgot_passwd.otp_attempts', 0);
        Session::put('forgot_passwd.domain', $this->domain);
        Session::put('forgot_passwd.login_name', $this->loginName);
        Session::put('forgot_passwd.mobile_phone', $this->mobile_phone);
        Session::put('forgot_passwd.user_id', $this->user_id);
    }

    public function otpEnteredCorrectly()
    {
        Session::put('forgot_passwd.otp_created_at', 0);
        Session::put('forgot_passwd.otp_validated_at', time());
    }

    public function getOTPMessage()
    {
        $name = $this->getOTPLoginName() . '@' . $this->getOTPDomain();
        $startTime = $this->getOPTStartTimeFormatted();
        $otp = $this->getOPTCode();
        return "Dear Customer, we have received a request to reset your password for user name {$name} on {$startTime}. Your OTP will be valid for next 10mins and your OTP is {$otp}.";
    }

    public function getOPTStartTimeFormatted()
    {
        $time = $this->getOPTStartTime();
        return date("d-M-Y H:m:s", $time);
    }

    public function getOPTValidatedTime()
    {
        $validatedTime = Session::get('forgot_passwd.otp_validated_at');
        return !is_null($validatedTime) ? $validatedTime : 0;
    }

    public function getOPTStartTime()
    {
        $startTime = Session::get('forgot_passwd.otp_created_at');
        return !is_null($startTime) ? $startTime : 0;
    }

    public function getOPTCode()
    {
        return Session::get('forgot_passwd.otp_value');
    }

    public function getOTPUserMobile()
    {
        return Session::get('forgot_passwd.mobile_phone');
    }

    public function getOTPDomain()
    {
        return Session::get('forgot_passwd.domain');
    }

    public function getOTPLoginName()
    {
        return Session::get('forgot_passwd.login_name');
    }

    public function getOTPUserId()
    {
        return Session::get('forgot_passwd.user_id');
    }

    public function otpIsActive()
    {
        return $this->otpSecondsRemainingValid() > 0 ? true : false;
    }

    public function otpSecondsRemainingValid()
    {
        $elapsedTime = time() - $this->getOPTStartTime();
        $tenMinutes = 10 * 60;
        if ($elapsedTime > $tenMinutes) {
            return 0;
        }
        return $tenMinutes - $elapsedTime;
    }

    public function otpTimeRemainingValid()
    {
        $seconds = $this->otpSecondsRemainingValid();
        $minutes = ceil($seconds/60);
        if ($minutes > 1) {
            return $minutes . ' minutes';
        }
        return $seconds . ' seconds';
    }

    public function otpPasswordIsActive()
    {
        return $this->otpPasswordSecondsRemainingValid() > 0 ? true : false;
    }

    public function otpPasswordSecondsRemainingValid()
    {
        $elapsedTime = time() - $this->getOPTValidatedTime();
        $tenMinutes = 10 * 60;
        if ($elapsedTime > $tenMinutes) {
            return 0;
        }
        return $tenMinutes - $elapsedTime;
    }

    public function otpPasswordTimeRemainingValid()
    {
        $seconds = $this->otpPasswordSecondsRemainingValid();
        $minutes = ceil($seconds/60);
        if ($minutes > 1) {
            return $minutes . ' minutes';
        }
        return $seconds . ' seconds';
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
