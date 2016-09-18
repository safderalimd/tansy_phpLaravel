<?php

namespace App\Http\Models;

use App\Http\Models\Model;
use Config;
use Session;

class MasterDB extends Model
{
    protected $screenId = null;

    protected $repositoryNamespace = 'App\Http\Repositories\MasterDBRepository';

    public static function initByLogin($login)
    {
        $domainName = last(explode('@', $login));
        return static::init($domainName);
    }

    public static function init($domainName)
    {
        $masterDB = new static(['domain_name' => $domainName]);
        return $masterDB->initSecondDb();
    }

    public function initSecondDb()
    {
        $secondDBCredentials = $this->getConnectionDataForSecondDB();
        if (!empty($secondDBCredentials)) {
            Session::put('dbConnectionData', $secondDBCredentials);
            $this->setSecondDBCredentials($secondDBCredentials);
            return true;
        }
        return false;
    }

    /**
     * Read the second database connection info from the master database
     *
     * @return array
     */
    public function getConnectionDataForSecondDB()
    {
        $this->setAttribute('debug_sproc', 0);
        $this->setAttribute('audit_screen_visit', 0);
        $data = $this->repository->getClientConnectionFromMasterDB($this);
        if (isset($data[0][0])) {
            return $data[0][0];
        }
        return [];
    }

    public function setSecondDBCredentials($secondDBCredentials)
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
}
