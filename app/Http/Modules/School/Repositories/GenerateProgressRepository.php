<?php

namespace App\Http\Modules\School\Repositories;

use App\Http\Repositories\Repository;

class GenerateProgressRepository extends Repository
{

    public function generateFilteredProgressGrid($id)
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
                subject_entity_id
            FROM view_sch_generate_progress_grid
            WHERE exam_entity_id = :id;', ['id' => $id]
        );
    }

    public function generateProgress($model)
    {
        $procedure = 'sproc_sch_generate_progress_dml';

        $iparams = [
            ':iparam_exam_entity_id',
            ':iparam_class_entity_id',
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
