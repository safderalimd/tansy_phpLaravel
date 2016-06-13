<?php

namespace App\Http\Modules\School\Repositories;

use App\Http\Repositories\Repository;

class ClassSubjectMapRepository extends Repository
{
    public function getModelById($id)
    {
        return $this->select(
            'SELECT
                class_name,
                subject,
                mapped,
                class_entity_id,
                subject_entity_id
             FROM view_sch_class2subject_grid
             WHERE subject_entity_id = :id
             LIMIT 1;', ['id' => $id]
        );
    }

    public function mapOrDelete($model)
    {
        $procedure = 'sproc_sch_class2subject_dml';

        $iparams = [
            ':iparam_class_entity_id',
            ':iparam_subject_entity_id',
            ':iparam_mapping_flag',
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
