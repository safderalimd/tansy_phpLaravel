<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Repository;

class UserRepository extends Repository
{
    public function login($model)
    {
        $procedure = 'sproc_sec_login';

        $iparams = [
            ':iparam_login_name',
            ':iparam_password',
            ':iparam_ipaddress',
        ];

        $oparams = [
            '@oparam_default_facility_id',
            '@oparam_session_id',
            '@oparam_user_id',
            '@oparam_login_success',
            '@oparam_login_err',
            '@oparam_company_name',
            '@oparam_debug_sproc',
            '@oparam_audit_screen_visit',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }
}