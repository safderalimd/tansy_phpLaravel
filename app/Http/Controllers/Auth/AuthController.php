<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Session;
use App\Http\Models\User;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;

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
     * The name of the login view.
     *
     * @var string
     */
    protected $loginView = 'login';

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(CookieJar $cookieJar, Request $request)
    {
        if ($request->has('remember')) {
            $cookieJar->queue(cookie('remember', true, 2628000));
        } else {
            $cookieJar->queue(cookie('remember', null, -2628000));
        }

        return $this->login($request);
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        $user = new User();
        $user->logout();
        $response = $this->logout();
        Session::flush();
        return $response;
    }
}
