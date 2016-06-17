<?php

namespace App\Http\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Admin\Models\ChangePassword;
use App\Http\Modules\Admin\Requests\ChangePasswordFormRequest;
use App\Exceptions\DbErrorException;

class ChangePasswordController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . ChangePassword::screenId());
    }

    public function index()
    {
        return view('modules.admin.Admin.change-password');
    }

    public function updatePassword(ChangePasswordFormRequest $request)
    {
        $password = new ChangePassword($request->input());

        try {
            $password->update();
        } catch (DbErrorException $e) {
            return redirect('/cabinet/change-password')->withErrors($e->getMessage());
        }

        flash('Password Updated!');
        return redirect('/cabinet');
    }

}
