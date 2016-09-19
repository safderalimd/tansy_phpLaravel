<?php

namespace App\Http\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Admin\Models\ChangePassword;
use App\Http\Modules\Admin\Requests\ChangePasswordFormRequest;
use App\Http\Modules\thirdparty\sms\SMS;
use App\Http\Modules\Admin\Requests\LoginOTPRequest;

class LoginOTPController extends Controller
{
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

        return view('modules.admin.LoginOTP.otp');
    }

    // todo: throtle like user login

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

    }
}
