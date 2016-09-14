<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Config;

class Cabinet
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->userLoggedIn($request)) {
            return redirect()->guest('/login')->withErrors(['test' => 'You need to login']);
        }

        if (force_change_password() && !$this->isPasswordScreen($request)) {
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

    public function userLoggedIn($request)
    {
        return $request->session()->has('user');
    }

    public function isPasswordScreen($request)
    {
        return 'cabinet/change-password' == $request->path();
    }
}
