<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Repository;

class ForgotPasswordRepository extends Repository
{
    public function changePassword($model)
    {
        $procedure = 'sproc_sec_change_password';

        $iparams = [
            '-iparam_old_password',
            '-iparam_new_password',
            ':iparam_ignore_old_password',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_send_change_password_sms',
            '@oparam_user_mobile',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function validateForgotPassword($model)
    {
        $procedure = 'sproc_sec_validate_forgot_password';

        $iparams = [
            '-iparam_login_name',
            '-iparam_user_mobile',
            '-iparam_ipaddress',
            '-iparam_login_media',
        ];

        $oparams = [
            '@oparam_user_id',
            '@oparam_verified_user',
            '@oparam_verified_err',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }
}
