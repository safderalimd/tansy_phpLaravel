<?php

namespace App\Http\Modules\School\Repositories;

use App\Http\Repositories\Repository;

class MarkSheetRepository extends Repository
{
    public function markSheetGrid($id)
    {
        return $this->db()->select(
            'SELECT
                class_name,
                subject,
                locked,
                progress_status,
                last_upload_modified_date,
                exam_entity_id,
                class_entity_id,
                subject_entity_id,
                marksheet_id
                FROM view_sch_mark_sheet_grid
                WHERE exam_entity_id = :id
                ORDER BY class_name DESC;', ['id' => $id]
        );
    }

    public function getMarkSheetRows($id)
    {
        return $this->db()->select(
            'SELECT
                student_roll_number,
                student_full_name,
                student_marks,
                class_entity_id,
                subject_entity_id,
                exam_entity_id,
                class_student_id,
                marksheet_id
            FROM view_sch_mark_sheet_detail
            WHERE marksheet_id = :id', ['id' => $id]
        );
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
            '@oparam_err_msg'
        ];

        return $this->runProcedure($model, $procedure, $iparams, $oparams);
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
            '@oparam_err_msg'
        ];

        return $this->runProcedure($model, $procedure, $iparams, $oparams);
    }
}
