<?php

namespace App\Http\Modules\Admin\Repositories;

use App\Http\Repositories\Repository;

class ChangePasswordRepository extends Repository
{
    public function update($model)
    {
        $procedure = 'sproc_sec_change_password';

        $iparams = [
            '-iparam_old_password',
            '-iparam_new_password',
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
}
