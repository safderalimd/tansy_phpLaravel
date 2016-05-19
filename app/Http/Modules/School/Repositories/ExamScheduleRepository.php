<?php

namespace App\Http\Modules\School\Repositories;

use App\Http\Repositories\Repository;

class ExamScheduleRepository extends Repository
{
    public function getExamGrid($id)
    {
        return $this->db()->select(
            'SELECT
                class_name,
                class_entity_id,
                subject_entity_id,
                subject,
                exam_date,
                exam_time,
                max_marks,
                class_subject_id,
                exam_entity_id
             FROM view_sch_schedule_exam_grid
             WHERE exam_entity_id = :id;', ['id' => $id]
        );
    }

    public function getScheduleExamGrid()
    {
        return $this->db()->select(
            'SELECT class_name, class_entity_id, subject_entity_id, subject, exam_date, exam_time, max_marks, class_subject_id, exam_entity_id
            FROM view_sch_schedule_exam_grid
            ORDER BY class_name DESC;'
        );
    }

    public function scheduleRows($model)
    {
        $procedure = 'sproc_sch_schedule_exam_dml_ins';

        $iparams = [
            ':iparam_class_subject_ids',
            ':iparam_exam_entity_id',
            ':iparam_exam_date',
            ':iparam_exam_start_time',
            ':iparam_exam_end_time',
            ':iparam_max_marks',
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

    public function mapSubjects($model)
    {
        $procedure = 'sproc_sch_schedule_exam_map_subject_dml';

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
            '@oparam_err_msg'
        ];

        return $this->runProcedure($model, $procedure, $iparams, $oparams);
    }

    public function delete($model)
    {
        $procedure = 'sproc_sch_schedule_exam_dml_del';

        $iparams = [
            ':iparam_class_entity_id',
            ':iparam_subject_entity_id',
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
            '@oparam_err_msg'
        ];

        return $this->runProcedure($model, $procedure, $iparams, $oparams);
    }
}
