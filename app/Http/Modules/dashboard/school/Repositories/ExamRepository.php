<?php

namespace App\Http\Modules\dashboard\school\Repositories;

use App\Http\Repositories\Repository;

class ExamRepository extends Repository
{
    public function getExamWithResult()
    {
        return $this->select(
            'SELECT exam, exam_type, exam_entity_id, reporting_order
            FROM view_sch_lkp_exam_with_result
            ORDER BY reporting_order ASC;'
        );
    }

    public function examInfo($model)
    {
        $procedure = 'sproc_dsh_sch_exam_v1';

        $iparams = [
            ':iparam_exam_entity_id',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_toppers_count',
            '@oparam_failed_students',
            '@oparam_absentee_students',
            '@oparam_pass_percentage',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function classPerformance($model)
    {
        $procedure = 'sproc_dsh_sch_exam_class_v1';

        $iparams = [
            ':iparam_exam_entity_id',
            ':iparam_exam_class_id',
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

    public function topperDetails($model)
    {
        $procedure = 'sproc_dsh_sch_exam_toppers_v1';

        $iparams = [
            ':iparam_exam_entity_id',
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

    public function failedStudents($model)
    {
        $procedure = 'sproc_dsh_sch_exam_failed_students_v1';

        $iparams = [
            ':iparam_exam_entity_id',
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


    public function absentees($model)
    {
        $procedure = 'sproc_dsh_sch_exam_absentees_v1';

        $iparams = [
            ':iparam_exam_entity_id',
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
