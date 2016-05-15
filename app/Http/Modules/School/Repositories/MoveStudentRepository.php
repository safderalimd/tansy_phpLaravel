<?php

namespace App\Http\Modules\School\Repositories;

use App\Http\Repositories\Repository;

class MoveStudentRepository extends Repository
{

    public function move($model)
    {
        $procedure = 'sproc_sch_move_student_class_dml';

        $iparams = [
            ':iparam_move_to_class_entity_id',
            ':iparam_move_to_fiscal_year_entity_id',
            ':iparam_class_student_ids',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg'
        ];

        return $this->runProcedure($model, $procedure, $iparams, $oparams);
    }
}
