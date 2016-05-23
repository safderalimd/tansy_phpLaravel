<?php

namespace App\Http\Modules\reports\School\Repositories;

use App\Http\Repositories\Repository;

class ProgressPrintStudentRepository extends Repository
{
    public function getStudentDetails($examId, $classId)
    {
        return $this->db()->select(
            'SELECT
                exam_entity_id,
                class_entity_id,
                subject_entity_id,
                class_student_id,
                subject,
                max_marks,
                student_marks,
                pass_fail
            FROM view_sch_progress_print_details
            WHERE exam_entity_id = :exam_id
            AND class_entity_id = :class_id
            ORDER BY subject ASC;', [
                'exam_id' => $examId,
                'class_id' => $classId,
            ]
        );
    }

    public function getExamName($id)
    {
        return $this->db()->select(
            'SELECT exam, exam_type, exam_entity_id
            FROM view_sch_lkp_exam
            WHERE exam_entity_id = :id
            ORDER BY exam ASC;', ['id' => $id]
        );
    }

    public function getSchoolName()
    {
        return $this->db()->select(
            'SELECT
                organization_name,
                work_phone,
                mobile_phone,
                email,
                address1,
                address2,
                city_area,
                postal_code,
                city_id,
                organization_type_id,
                organization_entity_id
            FROM view_org_organization_detail_owner
            LIMIT 1;'
        );
    }

    public function getProgressList($model)
    {
        $procedure = 'sproc_sch_progress_lst';

        $iparams = [
            '@iparam_exam_entity_id',
            '@iparam_class_entity_id',
            '@iparam_class_student_id',
            '@iparam_session_id',
            '@iparam_user_id',
            '@iparam_screen_id',
            '@iparam_debug_sproc',
            '@iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg'
        ];

        return $this->runReadProcedure($model, $procedure, $iparams, $oparams);
    }
}
