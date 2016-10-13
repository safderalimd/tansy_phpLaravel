<?php

namespace App\Http\Modules\Teacher\Repositories;

use App\Http\Repositories\Repository;

class TeacherQuickUpdateRepository extends Repository
{
    public function getDepartment2()
    {
        // department_id, department_name
        return $this->lookup('sproc_org_lkp_department2');
    }

    public function grid($model)
    {
        $procedure = 'sproc_sch_teacher_multiple_update_grid';

        $iparams = [
            ':iparam_department_id',
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
        $procedure = 'sproc_sch_teacher_multiple_update_dml';

        $iparams = [
            ':iparam_account_entity_id',
            '-iparam_short_name',
            ':iparam_row_department_id',
            ':iparam_class_teacher_class_entity_id',
            ':iparam_teacher_periods_quota_per_day',
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

