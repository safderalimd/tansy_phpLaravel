<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Repository;

class UserRepository extends Repository
{
    public function login($model)
    {
        $procedure = 'sproc_sec_login';

        $iparams = [
            '-iparam_login_name',
            '-iparam_password',
            '-iparam_ipaddress',
            '-iparam_login_media',

            // for remember me feature
            '-iparam_login_token',
            ':iparam_user_id',
        ];

        $oparams = [
            '@oparam_user_sec_group',
            '@oparam_default_facility_id',
            '@oparam_session_id',
            '@oparam_user_id',
            '@oparam_login_success',
            '@oparam_login_err',
            '@oparam_company_name',
            '@oparam_debug_sproc',
            '@oparam_audit_screen_visit',

            '@oparam_user_mobile',
            '@oparam_owner_mobile',
            '@oparam_force_change_password',
            '@oparam_send_login_sms',
            '@oparam_send_login_otp',

            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function updateRememberToken($model)
    {
        $procedure = 'sproc_sec_user_token_dml_upd';

        $iparams = [
            '-iparam_login_token',
            '-iparam_login_token_ip',
            '-iparam_login_media',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
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

    public function logout($model)
    {
        $procedure = 'sproc_sec_logout';

        $iparams = [
            ':iparam_session_id',
            ':iparam_user_id',
        ];

        $oparams = [
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }
}
