<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Session;
use Illuminate\Http\Request;
use App\Http\Models\User;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/cabinet';

    /**
     * Where to redirect users after logout.
     *
     * @var string
     */
    protected $redirectAfterLogout = '/login';

    /**
     * The input name for the username in the login form.
     *
     * @var string
     */
    protected $username = 'login';

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
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        return $this->login($request);
    }

    /**
     * Login the user.
     *
     * @param  Request $request
     * @return  \Illuminate\Http\Response
     */
    public function myLogin(Request $request)
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
                Session::put('dbHiddenMenuInfo', $user->hiddenMenuInfo);

                // clear the sms balance from the session
                session()->put('smsBalance', null);
                session()->put('smsAccountInactive', null);

                // force change password
                Session::put('user.forceChangePassword', $user->forceChangePassword());

                if ($user->forceChangePassword()) {
                    return redirect('/cabinet/change-password');

                } else {
                    return redirect()->intended('/cabinet');
                }
            }

        } catch(\Exception $e) {
            return redirect('/login')->withInput()->withErrors([['login' => 'Something went wrong. Try again later.']]);
        }

        return redirect('/login')->withInput()->withErrors(['login' => 'Error: You are not logged in.']);
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        Session::flush();
        return redirect('/login');

        return $this->logout();
    }

    /**
     * Logout the user.
     */
    public function myLogout()
    {
        $user = new User();
        $user->logout();
        Session::flush();
        return redirect('/login');
    }
}
