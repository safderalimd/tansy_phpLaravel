<?php

namespace App\Http\Modules\Parent\Repositories;

use App\Http\Repositories\Repository;

class MyTimeTableRepository extends Repository
{
    public function timeTable($model)
    {
        $procedure = 'sproc_sch_time_table_detail';

        $iparams = [
            ':iparam_account_entity_id',
            '-iparam_start_date',
            '-iparam_end_date',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_entity_type',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }
}
