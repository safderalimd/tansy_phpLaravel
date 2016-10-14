<?php

namespace App\Http\Modules\System\Repositories;

use App\Http\Repositories\Repository;

class TimeTablePeriodRepository extends Repository
{
    public function getGrid()
    {
        // period_id, period_type_id, period_type, period_name, start_time, end_time, reporting_order, active
        return $this->lookup('sproc_sch_time_table_period_grid');
    }

    public function getPeriodType()
    {
        // period_type_id, period_type
        return $this->lookup('sproc_sch_lkp_time_table_period_type');
    }

    public function insert($model)
    {
        $procedure = 'sproc_sch_time_table_period_dml_ins';

        $iparams = [
            ':iparam_period_type_id',
            '-iparam_period_name',
            '-iparam_start_time',
            '-iparam_end_time',
            ':iparam_reporting_order',
            ':iparam_active',
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

    public function update($model)
    {
        $procedure = 'sproc_sch_time_table_period_dml_upd';

        $iparams = [
            ':iparam_period_id',
            ':iparam_period_type_id',
            '-iparam_period_name',
            '-iparam_start_time',
            '-iparam_end_time',
            ':iparam_reporting_order',
            ':iparam_active',
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
