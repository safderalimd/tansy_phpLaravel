<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Config;
use Illuminate\Contracts\Auth\Guard;

class Cabinet
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            return redirect()->guest('/login')->withErrors(['test' => 'You need to login']);
        }

        if (force_change_password() && !$this->isPasswordScreen($request) && !$this->isLogoutScreen($request)) {
            return redirect('/cabinet/change-password');
        }

        $dbData = Session::get('dbConnectionData');

        $secondDB = array(
            'driver'    => 'mysql',
            'host'      => $dbData['db_server'],
            'database'  => $dbData['database_name'],
            'username'  => $dbData['sql_user_id'],
            'password'  => $dbData['sql_password'],
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        );

        Config::set('database.connections.secondDB', $secondDB);

        return $next($request);
    }

    public function isPasswordScreen($request)
    {
        return 'cabinet/change-password' == $request->path();
    }

    public function isLogoutScreen($request)
    {
        return 'cabinet/logout' == $request->path();
    }
}
