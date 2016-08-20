<?php

namespace App\Http\Modules\reports\School\Repositories;

use App\Http\Repositories\Repository;

class ProgressPrintClassRepository extends Repository
{
    // public function getExamName($id)
    // {
    //     return $this->select(
    //         'SELECT exam, exam_type, exam_entity_id
    //         FROM view_sch_lkp_exam
    //         WHERE exam_entity_id = :id
    //         ORDER BY exam ASC;', ['id' => $id]
    //     );
    // }

    // public function getSchoolName()
    // {
    //     return $this->select(
    //         'SELECT
    //             organization_name,
    //             work_phone,
    //             mobile_phone,
    //             email,
    //             address1,
    //             address2,
    //             city_area,
    //             postal_code,
    //             city_id,
    //             organization_type_id,
    //             organization_entity_id
    //         FROM view_org_organization_detail_owner
    //         LIMIT 1;'
    //     );
    // }

    public function getProgressList($model)
    {
        $procedure = 'sproc_sch_progress_lst';

        $iparams = [
            ':iparam_exam_entity_id',
            ':iparam_filter_entity_id',
            ':iparam_class_student_id',
            '-iparam_return_type',
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
