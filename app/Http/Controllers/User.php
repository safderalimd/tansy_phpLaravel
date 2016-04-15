<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class User extends Controller
{
    /**
     * @var Requests\Login
     */
    private $request;

    /**
     * @var \mysqli
     */
    private $dbConnection;

    /**
     * @param Requests\Login $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login(Requests\Login $request)
    {
        $this->request = $request;

        try {
            $loginData = $this->explodeLoginData($request->input());

            $this->dbConnection = $this->getDBConnection($loginData['domain']);

            if ($this->loginInDB($loginData['login'], $loginData['password'])) {
                return redirect('/cabinet');
            }

        } catch(\Exception $e) {
            return redirect('/login')->withInput()->withErrors([['login' => 'Something wrong. Try again later.']]);
        }

        return redirect('/login')->withInput()->withErrors(['login' => 'You are not logged in master DB.']);
    }

    public function logout() {

        if ($this->logoutInDB()) {
            Session::flush();

            return redirect('/login');
        }
    }

    /**
     * @param string $login
     * @param string $password
     * @return bool
     */
    private function loginInDB($login, $password)
    {
        $mysql = $this->dbConnection;

        $mysql->query("set @iparam_login_name = '{$mysql->escape_string($login)}';");
        $mysql->query("set @iparam_password = '{$mysql->escape_string($password)}';");

        $mysql->query("set @iparm_ipaddress = '{$mysql->escape_string($this->request->ip())}';");

        $sql  = 'call sproc_sec_login(@iparam_login_name,@iparam_password ,@iparm_ipaddress ,@oparam_session_id ,@oparam_user_id,@oparam_login_success, @oparam_login_err,@oparam_err_flag, @oparam_err_step, @oparam_err_msg);';
        $sql .= 'select @oparam_session_id, @oparam_user_id, @oparam_login_success, @oparam_login_err, @op_err_flag, @oparam_err_step, @oparam_err_msg;';

        if ($mysql->multi_query($sql)) {
            if ($result = $mysql->store_result()) {
                $menuInfo = $result->fetch_all(MYSQLI_ASSOC);
            }

            if ($mysql->more_results()) {
                $mysql->next_result();
            }
            if ($mysql->more_results()) {
                $mysql->next_result();
            }

            if ($result = $mysql->store_result()) {
                $loginInfo = $result->fetch_array(MYSQLI_ASSOC);
            }

//            $mysql->close();

            if ($loginInfo['@oparam_login_success'] == true && !empty($menuInfo)) {
                $this->request->session()->put('user.sessionID', $loginInfo['@oparam_session_id']);
                $this->request->session()->put('user.userID', $loginInfo['@oparam_user_id']);
                $this->request->session()->put('dbMenuInfo', $menuInfo);

                return true;
            }
        }

        return false;
    }

    private function logoutInDB()
    {
        $mysql = $this->getDBConnection();

        $userID = session('user.userID');
        $sessionID = session('user.sessionID');

        $mysql->query("set @iparam_session_id = '$sessionID';");
        $mysql->query("set @iparam_user_id = '$userID';");

        $mysql->query('call sproc_sec_logout (@iparam_session_id, @iparam_user_id, @oparam_err_flag, @oparam_err_step ,@oparam_err_msg);');
        $mysql->query('select @op_err_flag, @oparam_err_step, @oparam_err_msg;');

        return true;
    }

    /**
     * @param string $domain
     * @return \mysqli
     * @throws \Exception
     */
    private function getDBConnection($domain = null)
    {
        if ($domain !== null) {
            /** @var array $dbData */
            $dbData = DB::table('sama_login_info')->where('login_domain', $domain)->first();
        } else {
            $dbData = Session::get('dbConnectionData');
        }

        $connection = new \mysqli($dbData['db_server'], $dbData['sql_user_id'],
            $dbData['sql_password'], $dbData['database_name']);

        if ($connection->connect_errno) {
            throw new \Exception('Not established connect to master DB');
        }

        Session::put('dbConnectionData', $dbData);

        return $connection;
    }

    /**
     * @param array $inputData
     * @return array with login data
     */
    private function explodeLoginData(array $inputData)
    {
        $tempArray = explode('@', $inputData['login']);

        return [
            'domain' => $tempArray[1],
            'login' => $tempArray[0],
            'password' => $inputData['password'],
        ];
    }
}
