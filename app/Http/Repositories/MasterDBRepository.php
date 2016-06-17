<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Repository;
use DB;

class MasterDBRepository extends Repository
{
    /**
     * Get db connection for master database, specified in .env
     */
    public function db()
    {
        return DB::connection();
    }

    public function getClientConnectionFromMasterDB($model)
    {
        $procedure = 'sproc_sama_get_client_db_connnection_info';

        $iparams = [
            '-iparam_domain_name',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }
}
