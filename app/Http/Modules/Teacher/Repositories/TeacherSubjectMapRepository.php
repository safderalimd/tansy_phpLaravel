<?php

namespace App\Http\Modules\Teacher\Repositories;

use App\Http\Repositories\Repository;
use App\Http\Models\Model;

class TeacherSubjectMapRepository extends Repository
{
    public function getGrid($model)
    {
        $procedure = 'sproc_sch_subject_teacher_map_grid';

        $iparams = [
            ':iparam_individual_entity_id',
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

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }

    public function update($model)
    {
        $procedure = 'sproc_sch_subject_teacher_map_dml_update';

        $iparams = [
            ':iparam_individual_entity_id',
            ':iparam_subject_entity_id',
            '-iparam_class_IDs',
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
