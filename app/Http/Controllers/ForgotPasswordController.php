<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\ForgotPassword;
use App\Http\Requests\ForgotPasswordFormRequest;
use App\Http\Models\MasterDB;
use Illuminate\Cache\RateLimiter;
use Session;
use App\Http\Modules\thirdparty\sms\SMS;
use Cache;

class ForgotPasswordController extends Controller
{
    /**
     * Return the forgot password view.
     */
    public function index()
    {
        return view('forgot-password.form');
    }

    /**
     * Check if the username/mobile combination is correct.
     */
    public function validateForgotPassword(ForgotPasswordFormRequest $request)
    {
        // get the domain from the login field
        $domain = last(explode('@', $request->input('login_field')));

        // the wrong mobile/username combination will lock the user out for 30min
        if ($this->userIsLockedOut($domain)) {
            return redirect('/forgot-password')->withErrors($this->getLockedOutMessage($domain));
        }

        // try to initialize the maser db connection
        if (! MasterDB::init($domain)) {
            $this->lockOutUserFromDomain($domain);
            return redirect('/forgot-password')->withErrors($this->getNotAllowedMessage());
        }

        // try to validate the user/mobile combination
        $password = new ForgotPassword($request->input());
        $password->validateForgotPassword();

        if ($password->userCanResetPassword()) {

            // the user can use OTP now
            $password->activateOTPSession();
            SMS::otp()->oneSMS($password->getOTPUserMobile(), $password->getOTPMessage());
            return redirect('/forgot-password/otp');

        } else {

            // the user is locked out
            $this->lockOutUserFromDomain($domain);
            return redirect('/forgot-password')->withErrors($this->getNotAllowedMessage());

        }
    }

    /**
     * Show forgot password OTP view.
     */
    public function otp()
    {
        if (!$this->otpIsActive()) {
            return redirect('/forgot-password');
        }

        return view('forgot-password.otp');
    }

    public function validateOTP(Request $request)
    {
        if (!$this->otpIsActive()) {
            return redirect('/forgot-password');
        }

        // if ($this->hasTooManyLoginAttempts($request)) {
        //     return $this->sendLockoutResponse($request);
        // }

        // if ($otpIsValid) {
            // if ($password->sendForgotPasswordSMS()) {
            //     SMS::transactional()->oneSMS($password->getOTPUserMobile(), $password->getMessage());
            // }
        // }

        $this->incrementLoginAttempts($request);

        Session::put('forgot_passwd.otp_active', false);
    }

    /**
     * Check if 10min did not pass since the otp code was created
     */
    public function otpIsActive()
    {
        $password = new ForgotPassword;
        if (! $password->otpSessionIsActive()) {
            return false;
        }

        return $password->otpStillValid();
    }

    public function userIsLockedOut($domain)
    {
        return false;
        if (Cache::has($this->getCacheKey($domain))) {
            return true;
        }

        return false;
    }

    public function getLockedOutMessage($domain)
    {
        $availableIn = Cache::get($this->getCacheKey($domain)) - time();
        $minutes = $availableIn > 0 ? intval($availableIn / 60) : 1;
        return 'You have been locked out. Please try again in '.$minutes.' minutes.';
    }

    public function lockOutUserFromDomain($domain)
    {
        $decayMinutes = 30;
        $expireTime = time() + ($decayMinutes * 60);
        Cache::add($this->getCacheKey($domain), $expireTime, $decayMinutes);
    }

    public function getCacheKey($domain)
    {
        return $domain.'|'.userIp().':reset-password-lockout';
    }

    public function getNotAllowedMessage()
    {
        return 'Not allowed to use this feature, please contact system admin.';
    }
}
