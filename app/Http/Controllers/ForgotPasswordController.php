<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Admin\Models\ForgotPassword;
// use App\Http\Modules\Admin\Requests\ForgotPasswordFormRequest;
// use App\Exceptions\DbErrorException;
// use App\Http\Modules\thirdparty\sms\SMS;

class ForgotPasswordController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('screen:' . ForgotPassword::screenId());
    }

    public function index()
    {
        return view('forgot-password');
    }

    // public function updatePassword(ForgotPasswordFormRequest $request)
    // {
    //     $password = new ForgotPassword($request->input());

    //     try {
    //         $password->updatePassword();

    //         if ($password->sendForgotPasswordSMS()) {
    //             SMS::transactional()->oneSMS($password->userMobile(), $password->getMessage());
    //         }

    //     } catch (DbErrorException $e) {
    //         return redirect('/cabinet/change-password')->withErrors($e->getMessage());
    //     }

    //     flash('Password Updated!');
    //     return redirect('/cabinet');
    // }
}
