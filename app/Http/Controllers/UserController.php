<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\User;
use App\Http\Requests\LoginFormRequest;

class UserController extends Controller
{
    /**
     * Show login screen.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('login');
    }

    /**
     * Login the user.
     *
     * @param  LoginFormRequest $request
     * @return  \Illuminate\Http\Response
     */
    public function login(LoginFormRequest $request)
    {
        try {

            // create an user model with form input
            $user = new User($request->input());

            // read and set the second database credentials from the master database
            $secondDBCredentials = $user->getConnectionDataForSecondDB();

            Session::put('dbConnectionData', $secondDBCredentials);
            User::setSecondDBCredentials($secondDBCredentials);

            // try to log in the user
            if ($user->login()) {

                Session::put('user.user_name', $user->user_name);
                Session::put('user.domain_name', trim($user->domain_name));

                Session::put('user.defaultFacilityId', $user->default_facility_id);

                Session::put('user.sessionID', $user->session_id);
                Session::put('user.userID', $user->user_id);
                Session::put('user.userSecurityGroup', $user->user_sec_group);
                Session::put('user.debugSproc', $user->debug_sproc);
                Session::put('user.auditScreenVisit', $user->audit_screen_visit);

                Session::put('user.companyName', $user->company_name);
                Session::put('dbMenuInfo', $user->menuInfo);

                return redirect('/cabinet');
            }

        } catch(\Exception $e) {
            return redirect('/login')->withInput()->withErrors([['login' => 'Something went wrong. Try again later.']]);
        }

        return redirect('/login')->withInput()->withErrors(['login' => 'Error: You are not logged in.']);
    }

    /**
     * Logout the user.
     */
    public function logout()
    {
        $user = new User();
        $user->logout();
        Session::flush();
        return redirect('/login');
    }
}
