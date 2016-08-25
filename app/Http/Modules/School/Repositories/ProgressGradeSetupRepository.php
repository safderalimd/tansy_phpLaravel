<?php

namespace App\Http\Modules\School\Repositories;

use App\Http\Repositories\Repository;

class ProgressGradeSetupRepository extends Repository
{
    public function gradingSystem($model)
    {
        $procedure = 'sproc_sch_lkp_exam_grading_system';
        $data = $this->procedure($model, $procedure, [], []);
        return first_resultset($data);
    }

    public function gradePassFail($model)
    {
        $procedure = 'sproc_sch_lkp_progress_grade_pass_fail';
        $data = $this->procedure($model, $procedure, [], []);
        return first_resultset($data);
    }

    public function getGrid($model)
    {
        $procedure = 'sproc_sch_progress_grade_setup_grid';

        $iparams = [
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

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }

    public function insert($model)
    {
        $procedure = 'sproc_sch_progress_grade_setup_dml_ins';

        $iparams = [
            '+iparam_start_percent',
            '+iparam_end_percent',
            '-iparam_grade',
            '-iparam_pass_fail',
            '+iparam_gpa',
            ':iparam_grade_system_id',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_grade_entity_id',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function update($model)
    {
        $procedure = 'sproc_sch_progress_grade_setup_dml_upd';

        $iparams = [
            ':iparam_grade_entity_id',
            '+iparam_start_percent',
            '+iparam_end_percent',
            '-iparam_grade',
            '-iparam_pass_fail',
            '+iparam_gpa',
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

    public function delete($model)
    {
        $procedure = 'sproc_sch_exam_progress_grade_dml_del';

        $iparams = [
            ':iparam_grade_entity_id',
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
