<?php

namespace App\Http\Models;

use App\Http\Models\Model;
use App\Http\Repositories\MasterDBRepository;
use Config;
use App\Http\DetectDevice\Device;

class User extends Model
{
    protected $screenId = null;

    protected $repositoryNamespace = 'App\Http\Repositories\UserRepository';

    public $menuInfo;

    public $hiddenMenuInfo;

    public function setLoginAttribute($login)
    {
        $tmp = explode('@', $login);
        $this->setAttribute('user_name', $tmp[0]);
        $this->setAttribute('domain_name', $tmp[1]);
        return $login;
    }

    /**
     * Read the second database connection info from the master database
     *
     * @return array
     */
    public function getConnectionDataForSecondDB()
    {
        $repository = new MasterDBRepository;
        $this->setAttribute('debug_sproc', 0);
        $this->setAttribute('audit_screen_visit', 0);
        $data = $repository->getClientConnectionFromMasterDB($this);
        if (isset($data[0][0])) {
            return $data[0][0];
        }
        return [];
    }

    public function login()
    {
        $this->setAttribute('login_media', Device::type());
        $this->setAttribute('login_name', $this->user_name);
        $this->setAttribute('ipaddress', userIp());
        $data = $this->repository->login($this);
        $this->menuInfo = first_resultset($data);
        $this->hiddenMenuInfo = second_resultset($data);

        $this->attributes['hasValidCredentials'] = false;
        return $this->userIsLoggedIn();
    }

    public function userIsLoggedIn()
    {
        if ($this->err_flag == 1) {
            return false;
        }

        if ($this->login_success == 1 && !empty($this->menuInfo)) {
            $this->attributes['hasValidCredentials'] = true;
            return true;
        }

        return false;
    }

    public function logout()
    {
        return $this->repository->logout($this);
    }

    public static function setSecondDBCredentials($secondDBCredentials)
    {
        $secondDB = array(
            'driver'    => 'mysql',
            'host'      => $secondDBCredentials['db_server'],
            'database'  => $secondDBCredentials['database_name'],
            'username'  => $secondDBCredentials['sql_user_id'],
            'password'  => $secondDBCredentials['sql_password'],
            'charset'   => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix'    => '',
        );

        Config::set('database.connections.secondDB', $secondDB);
    }

    public function forceChangePassword()
    {
        return $this->force_change_password == 1;
    }
}
