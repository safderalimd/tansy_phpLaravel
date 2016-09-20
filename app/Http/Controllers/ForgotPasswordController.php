<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\ForgotPassword;
use App\Http\Requests\ForgotPasswordFormRequest;
use App\Http\Requests\ForgotPasswordOTPRequest;
use App\Http\Requests\ForgotPasswordResetRequest;
use App\Http\Models\MasterDB;
use App\Http\ForgotPassword\PasswordThrottle;
use App\Http\ForgotPassword\OTPThrottle;
use SMS;

class ForgotPasswordController extends Controller
{
    use PasswordThrottle, OTPThrottle;

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
        $domain = $this->getDomain($request);

        // the wrong mobile/username combination will lock the user out for 30min
        if ($this->userIsLockedOut($domain)) {
            return redirect('/forgot-password')->withErrors($this->getLockedOutMessage($domain));
        }

        // the user is locked out after the first attempt
        $this->lockOutUserFromDomain($domain);

        // try to initialize the maser db connection
        if (! MasterDB::init($domain)) {
            return redirect('/forgot-password')->withErrors($this->getNotAllowedMessage());
        }

        // try to validate the user/mobile combination
        $password = new ForgotPassword($request->input());
        $password->validateForgotPassword();

        if ($password->userCanResetPassword()) {
            // the user can use OTP now
            $password->activateOTPSession();
            SMS::otp()->forgotPasswordOTP($password->getOTPUserMobile(), $password->getOTPMessage());
            return redirect('/forgot-password/otp');

        } else {
            return redirect('/forgot-password')->withErrors($this->getNotAllowedMessage());
        }
    }

    /**
     * Show forgot password OTP view.
     *
     * @return \Illuminate\Http\Response
     */
    public function otp()
    {
        if ($this->otpLockedOut()) {
            return redirect('/forgot-password')->withErrors($this->otpLockedOutMessage());
        }

        $password = new ForgotPassword;
        if (! $password->otpIsActive()) {
            return redirect('/forgot-password')->withErrors($this->otpExpiredMessage());
        }

        return view('forgot-password.otp', compact('password'));
    }

    /**
     * Validate the otp the user entered. Allow only 2 attempts.
     *
     * @param ForgotPasswordOTPRequest $request
     * @return \Illuminate\Http\Response
     */
    public function validateOTP(ForgotPasswordOTPRequest $request)
    {
        // check if the otp was entered too many wrong times
        if ($this->otpLockedOut()) {
            return redirect('/forgot-password')->withErrors($this->otpLockedOutMessage());
        }

        // check that the otp is not expired
        $password = new ForgotPassword;
        if (! $password->otpIsActive()) {
            return redirect('/forgot-password')->withErrors($this->otpExpiredMessage());
        }

        // try to initialize the maser db connection
        if (! MasterDB::init($password->getOTPDomain())) {
            return redirect('/forgot-password')->withErrors($this->errorMasterDB());
        }

        $this->incrementOTPAttempts();

        if ($password->validOTP($request->input('otp_code'))) {
            $password->otpEnteredCorrectly();
            return redirect('/forgot-password/reset');

        } else {
            $url = ($this->remainingOTPTries() > 0) ? '/forgot-password/otp' : '/forgot-password';
            return redirect($url)->withErrors($this->remainingOTPTriesMessage());
        }
    }

    /**
     * Resend the OTP sms.
     *
     * @return \Illuminate\Http\Response
     */
    public function otpResend()
    {
        // check if the otp was entered too many wrong times
        if ($this->otpLockedOut()) {
            return redirect('/forgot-password')->withErrors($this->otpLockedOutMessage());
        }

        // check that the otp is not expired
        $password = new ForgotPassword;
        if (! $password->otpIsActive()) {
            return redirect('/forgot-password')->withErrors($this->otpExpiredMessage());
        }

        // try to initialize the maser db connection
        if (! MasterDB::init($password->getOTPDomain())) {
            return redirect('/forgot-password')->withErrors($this->errorMasterDB());
        }

        SMS::otp()->forgotPasswordOTP($password->getOTPUserMobile(), $password->getOTPMessage());
        return redirect('/forgot-password/otp')->with('otp-resent', 'The SMS was resent. Please check your phone.');
    }

    /**
     * Show form to enter new password.
     *
     * @return \Illuminate\Http\Response
     */
    public function password()
    {
        $password = new ForgotPassword;
        if (! $password->otpPasswordIsActive()) {
            return redirect('/forgot-password')->withErrors($this->otpPasswordExpiredMessage());
        }

        return view('forgot-password.new-password', compact('password'));
    }

    /**
     * Update the new password.
     *
     * @param ForgotPasswordResetRequest $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(ForgotPasswordResetRequest $request)
    {
        $password = new ForgotPassword;
        if (! $password->otpPasswordIsActive()) {
            return redirect('/forgot-password')->withErrors($this->otpPasswordExpiredMessage());
        }

        // try to initialize the maser db connection
        if (! MasterDB::init($password->getOTPDomain())) {
            return redirect('/forgot-password')->withErrors($this->errorMasterDB());
        }

        $password->setAttribute('new_password', $request->input('new_password'));
        $password->resetPassword();

        if ($password->sendChangePasswordSMS()) {
            SMS::transactional()->changePassword($password->userMobile(), $password->getChangePasswordMessage());
        }

        return redirect('/login')->with('login-message', 'Your password has been reset. Please login using your new password.');
    }
}
