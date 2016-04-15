<?php

namespace App\Http\Middleware;

use Closure;

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
        if ( !$request->session()->has('user') ) {
            return redirect('/login')->withErrors(['test' => 'You need to login']);
        }

        $dbData = \Session::get('dbConnectionData');

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

        \Config::set('database.connections.secondDB', $secondDB);

        return $next($request);
    }
}
