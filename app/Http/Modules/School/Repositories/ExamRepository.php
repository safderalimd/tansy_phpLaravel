<?php

namespace App\Http\Modules\School\Repositories;

use App\Http\Repositories\Repository;

class ExamRepository extends Repository
{
    public function getModelById($id)
    {
        return $this->select(
            'SELECT
                exam_entity_id,
                exam AS exam_name,
                exam_type_id,
                active,
                reporting_order,
                progress_card_reporting_order
             FROM view_sch_exam_detail
             WHERE exam_entity_id = :id
             LIMIT 1;', ['id' => $id]
        );
    }

    public function getExamGrid()
    {
        return $this->select(
            'SELECT
                exam,
                exam_type,
                exam_entity_id,
                reporting_order
             FROM view_sch_exam_grid
             ORDER BY reporting_order ASC;'
        );
    }

    public function getExamTypes()
    {
        return $this->select(
            'SELECT
                exam_type_id,
                exam_type
             FROM view_sch_lkp_exam_type;'
        );
    }

    public function insert($model)
    {
        $procedure = 'sproc_sch_exam_dml_ins';

        $iparams = [
            '-iparam_exam_name',
            ':iparam_exam_type_id',
            '-iparam_reporting_order',
            '-iparam_progress_card_reporting_order',
            ':iparam_facility_ids',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_exam_entity_id',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function update($model)
    {
        $procedure = 'sproc_sch_exam_dml_upd';

        $iparams = [
            ':iparam_exam_entity_id',
            '-iparam_exam_name',
            ':iparam_exam_type_id',
            '-iparam_reporting_order',
            '-iparam_progress_card_reporting_order',
            ':iparam_active',
            ':iparam_facility_ids',
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
        $procedure = 'sproc_sch_exam_dml_del';

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
