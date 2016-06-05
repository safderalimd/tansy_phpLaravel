<?php

namespace App\Http\Modules\School\Repositories;

use App\Http\Repositories\Repository;

class MarkSheetRepository extends Repository
{
    public function markSheetGrid($id)
    {
        return $this->select(
            'SELECT
                class_name,
                subject,
                locked,
                progress_status,
                last_upload_modified_date,
                exam_entity_id,
                class_entity_id,
                subject_entity_id,
                class_reporting_order,
                subject_reporting_order
                FROM view_sch_mark_sheet_grid
                WHERE exam_entity_id = :id
                ORDER BY class_reporting_order, subject_reporting_order ASC;',
                ['id' => $id]
        );
    }

    public function getMarkSheetEditForm($model)
    {
        return $this->select(
            'SELECT
                student_roll_number,
                class_entity_id,
                subject_entity_id,
                exam_entity_id,
                class_student_id,
                class_name,
                subject_name,
                exam_name,
                student_full_name,
                student_marks,
                max_marks,
                mark_sheet_code
            FROM view_sch_mark_sheet_detail
            WHERE class_entity_id = :class_entity_id
            AND subject_entity_id = :subject_entity_id
            AND exam_entity_id = :exam_entity_id', [
                'class_entity_id' => $model->class_entity_id,
                'subject_entity_id' => $model->subject_entity_id,
                'exam_entity_id' => $model->exam_entity_id,
            ]
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
        $procedure = 'sproc_sch_mark_sheet_dml_upd';

        $iparams = [
            ':iparam_exam_entity_id',
            ':iparam_class_entity_id',
            ':iparam_subject_entity_id',
            ':iparam_clsStudIDs_marks',
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
