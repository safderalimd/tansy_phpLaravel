<?php

namespace App\Http\Modules\School\Repositories;

use App\Http\Repositories\Repository;

class MarkSheetRepository extends Repository
{
    public function examDropdown($model)
    {
        $procedure = 'sproc_sch_lkp_main_exam';
        $iparams = [];
        $oparams = [];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }

    public function getGrid($model)
    {
        $procedure = 'sproc_sch_exam_marksheet_grid1';

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

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }

    public function marksGrid($model)
    {
        $procedure = 'sproc_sch_exam_marksheet_grid2';

        $iparams = [
            ':iparam_exam_entity_id',
            ':iparam_class_entity_id',
            ':iparam_subject_entity_id',
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

    public function unlock($model)
    {
        $procedure = 'sproc_sch_mark_sheet_unlock_dml';

        $iparams = [
            ':iparam_exam_entity_id',
            ':iparam_class_entity_id',
            ':iparam_subject_entity_id',
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

    public function lock($model)
    {
        $procedure = 'sproc_sch_mark_sheet_lock_dml';

        $iparams = [
            ':iparam_exam_entity_id',
            ':iparam_class_entity_id',
            ':iparam_subject_entity_id',
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

    public function save($model)
    {
        $procedure = 'sproc_sch_exam_marksheet_dml_upd';

        $iparams = [
            '-iparam_exSchID_clsStudntID_marks',
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
