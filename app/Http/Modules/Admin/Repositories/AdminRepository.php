<?php

namespace App\Http\Modules\Admin\Repositories;

use App\Http\Repositories\Repository;

class AdminRepository extends Repository
{
    public function debugReset()
    {
        $pdo = $this->db()->getPdo();

        $procedure = 'call sproc_sys_solve_duplicate_error';
        $pdo->query($procedure);
    }

    public function homeDisplay($model)
    {
        $procedure = 'sproc_org_home_display';

        $iparams = [
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
