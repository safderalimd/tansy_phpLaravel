<?php

namespace App\Http\Modules\Teacher\Repositories;

use App\Http\Repositories\Repository;

class MonthlyAttendanceRepository extends Repository
{
    public function grid($model)
    {
        $procedure = 'sproc_org_individual_absentee_monthly_grid';

        $iparams = [
            ':iparam_month_id',
            ':iparam_filter_entity_id',
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

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }

    public function update($model)
    {
        $procedure = 'sproc_org_individual_absentee_monthly_dml';

        $iparams = [
            ':iparam_month_id',
            ':iparam_working_days_count',
            '-iparam_actEntID_presenceDays',
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
