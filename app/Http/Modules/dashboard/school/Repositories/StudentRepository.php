<?php

namespace App\Http\Modules\dashboard\school\Repositories;

use App\Http\Repositories\Repository;

class StudentRepository extends Repository
{
    public function getExamWithResult()
    {
        return $this->select(
            'SELECT exam, exam_type, exam_entity_id, reporting_order
            FROM view_sch_lkp_exam_with_result
            ORDER BY reporting_order ASC;'
        );
    }

    public function studentInfo($model)
    {
        $procedure = 'sproc_dsh_sch_student_v1';

        $iparams = [
            ':iparam_class_student_id',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_overall_grade',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function studentList($model)
    {
        $procedure = 'sproc_act_rcv_due_lst';

        $iparams = [
            ':iparam_filter_type',
            ':iparam_subject_entity_id',
            ':iparam_return_type',
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

    public function examDetails($model)
    {
        $procedure = 'sproc_dsh_sch_student_exam_subject_performance_v1';

        $iparams = [
            ':iparam_class_student_id',
            ':iparam_exam_entity_id',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_exam_grade',
            '@oparam_exam_result',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function overallDetails($model)
    {
        $procedure = 'sproc_dsh_sch_student_exam_performance_v1';

        $iparams = [
            ':iparam_class_student_id',
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

    public function smsHistory($model)
    {
        $procedure = 'sproc_dsh_sch_student_sms_history_v1';

        $iparams = [
            ':iparam_class_student_id',
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
}
