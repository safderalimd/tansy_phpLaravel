<?php

namespace App\Http\Modules\School\Repositories;

use App\Http\Repositories\Repository;

class ExamSetupRepository extends Repository
{
    public function examDropdown($model)
    {
        $procedure = 'sproc_sch_lkp_main_exam';
        $data = $this->procedure($model, $procedure, [], []);
        return first_resultset($data);
    }

    public function subExamDropdown($model)
    {
        $procedure = 'sproc_sch_lkp_sub_exam';
        $data = $this->procedure($model, $procedure, [], []);
        return first_resultset($data);
    }

    public function studentReport($model)
    {
        $procedure = 'sproc_sch_lkp_exam_student_report_version';
        $data = $this->procedure($model, $procedure, [], []);
        return first_resultset($data);
    }

    public function gradingSystem($model)
    {
        $procedure = 'sproc_sch_lkp_exam_grading_system';
        $data = $this->procedure($model, $procedure, [], []);
        return first_resultset($data);
    }

    public function classDropdown($model)
    {
        $procedure = 'sproc_sch_lkp_class_account_type';
        $iparams = [];
        $oparams = [];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }

    public function getExamSetupGrid($model)
    {
        $procedure = 'sproc_sch_exam_setup_grid';

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

    public function insert($model)
    {
        $procedure = 'sproc_sch_exam_setup_dml_ins';

        $iparams = [
            ':iparam_exam_entity_id',
            ':iparam_sub_exam_entity_id',
            ':iparam_class_entity_id',
            ':iparam_subjectIDS',
            ':iparam_max_marks',
            ':iparam_average_reduced_marks',
            ':iparam_exam_date',
            ':iparam_exam_start_time',
            ':iparam_exam_end_time',
            ':iparam_grade_system_id',
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
        $procedure = 'sproc_sch_schedule_exam_dml_upd';

        $iparams = [
            ':iparam_exam_schedule_id',
            ':iparam_exam_entity_id',
            ':iparam_sub_exam_entity_id',
            ':iparam_class_entity_id',
            ':iparam_subject_entity_id',
            ':iparam_max_marks',
            ':iparam_average_reduced_marks',
            '-iparam_exam_date',
            '-iparam_exam_start_time',
            '-iparam_exam_end_time',
            ':iparam_grade_system_id',
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

    public function detail($model)
    {
        $procedure = 'sproc_sch_schedule_exam_details';

        $iparams = [
            ':iparam_exam_schedule_id',
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

    public function delete($model)
    {
        $procedure = 'sproc_sch_schedule_exam_dml_del';

        $iparams = [
            ':iparam_exam_schedule_id',
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

    public function copy($model)
    {
        $procedure = 'sproc_sch_exam_setup_dml_copy';

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
