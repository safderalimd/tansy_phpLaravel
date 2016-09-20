<?php

namespace App\Http\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Admin\Models\ChangePassword;
use App\Http\Modules\Admin\Requests\ChangePasswordFormRequest;
use App\Http\Modules\Admin\Requests\LoginOTPRequest;
use App\Http\Modules\Admin\Controllers\Traits\LoginOTPThrottle;
use SMS;

class LoginOTPController extends Controller
{
    use LoginOTPThrottle;

    /**
     * Show OTP form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!force_login_otp()) {
            return redirect('/cabinet');
        }

        if ($this->loginOTPExpired()) {
            return $this->loginOTPExpiredResponse();
        }

        $timeValid = $this->otpTimeRemainingValid();
        return view('modules.admin.LoginOTP.otp', compact('timeValid'));
    }

    /**
     * Validate the otp the user entered.
     *
     * @param LoginOTPRequest $request
     * @return \Illuminate\Http\Response
     */
    public function checkOTP(LoginOTPRequest $request)
    {
        if (!force_login_otp()) {
            return redirect('/cabinet');
        }

        if ($this->loginOTPExpired()) {
            return $this->loginOTPExpiredResponse();
        }

        if ($this->hasTooManyOTPAttempts()) {
            return $this->sendLockoutResponse();
        }

        $this->incrementOTPLoginAttempts();

        if ($this->isValidOTP($request->input('otp_code'))) {
            $this->allowUserToEnter();
            flash('OTP Validated!');
            return redirect('/cabinet');
        } else {
            return redirect('/cabinet/otp')->withErrors('Wrong OTP code. Please try again.');
        }
    }

    /**
     * Resend the OTP sms.
     *
     * @return \Illuminate\Http\Response
     */
    public function resendOTP()
    {
        if (!force_login_otp()) {
            return redirect('/cabinet');
        }

        if ($this->loginOTPExpired()) {
            return $this->loginOTPExpiredResponse();
        }

        SMS::otp()->loginOTP($this->getMobile(), $this->getLoginOTPMessage());
        return redirect('/cabinet/otp')->with('otp-resent', 'The SMS was resent. Please check your phone.');
    }
}
