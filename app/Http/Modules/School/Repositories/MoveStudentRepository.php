<?php

namespace App\Http\Modules\School\Repositories;

use App\Http\Repositories\Repository;

class MoveStudentRepository extends Repository
{
    public function getStudentsGrid($model)
    {
        $procedure = 'sproc_sch_lkp_student';

        $iparams = [
            ':iparam_class_entity_id',
            ':iparam_student_entity_id',
            ':iparam_class_student_id',
        ];

        $data = $this->procedure($model, $procedure, $iparams, []);
        return first_resultset($data);

        // return $this->select(
        //     'SELECT
        //         student_full_name,
        //         first_name,
        //         middle_name,
        //         last_name,
        //         class_name,
        //         student_roll_number,
        //         fiscal_year,
        //         mobile_phone,
        //         active,
        //         class_student_id,
        //         student_entity_id,
        //         class_entity_id,
        //         class_category_entity_id,
        //         class_group_entity_id,
        //         fiscal_year_entity_id,
        //         class_reporting_order
        //     FROM view_sch_lkp_student
        //     WHERE class_entity_id = :id
        //     ORDER BY student_roll_number ASC;', ['id' => $id]
        // );
    }

    public function move($model)
    {
        $procedure = 'sproc_sch_move_student_class_dml';

        $iparams = [
            ':iparam_move_to_class_entity_id',
            ':iparam_move_to_fiscal_year_entity_id',
            '-iparam_class_student_ids',
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
