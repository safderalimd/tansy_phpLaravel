<?php

namespace App\Http\Modules\Admin\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Str;
use Session;
use Cache;

trait LoginOTPThrottle
{
    /**
     * Check if this otp is valid.
     *
     * @param  string  $otp
     * @return boolean
     */
    protected function isValidOTP($otp)
    {
        return trim($otp) == $this->getOPTCode();
    }

    /**
     * Allow the ueser to see the site.
     *
     * @return void
     */
    protected function allowUserToEnter()
    {
        Session::put('user.forceLoginOTPCode', false);
    }

    /**
     * Get the otp login message.
     *
     * @return string
     */
    protected function getLoginOTPMessage()
    {
        $name = $this->getLogin();
        $startTime = $this->getOPTStartTimeFormatted();
        $otp = $this->getOPTCode();
        // return "Dear Customer, we have received a request to login for user name {$name} on {$startTime}. Your OTP will be valid for next 10mins and your OTP is {$otp}.";
        // return "Login OTP is {$otp} for {$name}. Sent at {$startTime}.";
        return "YOUR REQUESTED OTP FROM TANSYCLOUD IS {$otp}";
    }

    /**
     * Get the mobile number to send the otp.
     *
     * @return int
     */
    protected function getMobile()
    {
        return Session::get('user.user_mobile');
    }

    /**
     * Generate the cache key for the throttle.
     *
     * @return string
     */
    protected function getThrottleKey()
    {
        return $this->getLogin().'|'.userIp().'|login-otp';
    }

    /**
     * Generate the cache key for the otp.
     *
     * @return string
     */
    protected function getOTPCacheKey()
    {
        return $this->getLogin().'|'.userIp().'|login-otp-code';
    }

    /**
     * Get the login username@domain value.
     *
     * @return string
     */
    protected function getLogin()
    {
        $userName = Session::get('user.user_name');
        $domain = Session::get('user.domain_name');
        return $userName.'@'.$domain;
    }

    /**
     * Generate 8 digit alpha-numeric code
     *
     * @return string
     */
    protected function generateOTPCode()
    {
        return generate_otp_code();
    }

    /**
     * Store the otp code in the cache.
     *
     * @return void
     */
    protected function storeLoginOTPCode()
    {
        $otp = $this->generateOTPCode();
        $decayMinutes = $this->otpDecayMinutes();
        $startTime = time();
        if (! Cache::has($this->getOTPCacheKey())) {
            Cache::add($this->getOTPCacheKey(), compact('otp', 'startTime'), $decayMinutes);
        }
    }

    protected function getOPTCode()
    {
        $otp = Cache::get($this->getOTPCacheKey());
        return isset($otp['otp']) ? $otp['otp'] : null;
    }

    protected function getOPTStartTimeFormatted()
    {
        $time = $this->getOPTStartTime();
        return date("d-M-Y H:m:s", $time);
    }

    protected function getOPTStartTime()
    {
        $otp = Cache::get($this->getOTPCacheKey());
        return isset($otp['startTime']) ? $otp['startTime'] : null;
    }

    protected function otpSecondsRemainingValid()
    {
        $elapsedTime = time() - $this->getOPTStartTime();
        $validTime = $this->otpDecayMinutes() * 60;
        if ($elapsedTime > $validTime) {
            return 0;
        }
        return $validTime - $elapsedTime;
    }

    protected function otpTimeRemainingValid()
    {
        $seconds = $this->otpSecondsRemainingValid();
        $minutes = ceil($seconds/60);
        if ($minutes > 1) {
            return $minutes . ' minutes';
        }
        return $seconds . ' seconds';
    }

    protected function loginOTPExpired()
    {
        if ($this->otpSecondsRemainingValid() <= 0) {
            return true;
        }
        return false;
    }

    protected function loginOTPExpiredResponse()
    {
        $this->clearLoginAttempts();
        Session::flush();
        return redirect('/login')->withErrors('Login OTP has expired. Please try again.');
    }

    /**
     * Determine if the user has too many failed login attempts.
     *
     * @return bool
     */
    protected function hasTooManyOTPAttempts()
    {
        return app(RateLimiter::class)->tooManyAttempts(
            $this->getThrottleKey(),
            $this->maxLoginOTPAttempts(), $this->lockoutTime() / 60
        );
    }

    /**
     * Increment the login attempts for the user.
     *
     * @return int
     */
    protected function incrementOTPLoginAttempts()
    {
        app(RateLimiter::class)->hit(
            $this->getThrottleKey()
        );
    }

    /**
     * Determine how many retries are left for the user.
     *
     * @return int
     */
    protected function retriesLeft()
    {
        return app(RateLimiter::class)->retriesLeft(
            $this->getThrottleKey(),
            $this->maxLoginOTPAttempts()
        );
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLockoutResponse()
    {
        $seconds = $this->secondsRemainingOnLockout();
        return redirect('/cabinet/otp')->withErrors($this->getLockoutErrorMessage($seconds));
    }

    /**
     * Get the login lockout error message.
     *
     * @param  int  $seconds
     * @return string
     */
    protected function getLockoutErrorMessage($seconds)
    {
        return 'Too many login OTP attempts. Please try again in '.$seconds.' seconds.';
    }

    /**
     * Get the lockout seconds.
     *
     * @return int
     */
    protected function secondsRemainingOnLockout()
    {
        return app(RateLimiter::class)->availableIn(
            $this->getThrottleKey()
        );
    }

    /**
     * Clear the login locks for the given user credentials.
     *
     * @return void
     */
    protected function clearLoginAttempts()
    {
        app(RateLimiter::class)->clear(
            $this->getThrottleKey()
        );
    }

    /**
     * Get the maximum number of login attempts for delaying further attempts.
     *
     * @return int
     */
    protected function maxLoginOTPAttempts()
    {
        return 2;
    }

    /**
     * The number of seconds to delay further login attempts.
     *
     * @return int
     */
    protected function lockoutTime()
    {
        return 60;
    }

    /**
     * The number of minutes the otp is valid.
     *
     * @return int
     */
    protected function otpDecayMinutes()
    {
        return 10;
    }
}
