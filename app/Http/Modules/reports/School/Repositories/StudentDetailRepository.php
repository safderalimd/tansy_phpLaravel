<?php

namespace App\Http\Modules\reports\School\Repositories;

use App\Http\Repositories\Repository;
use App\Http\Models\Model;

class StudentDetailRepository extends Repository
{
    public function getPdfData($id)
    {
        $model = new Model;
        $model->setAttribute('filter_type', 'All Students');
        $model->setAttribute('filter_entity_id', $id);

        $procedure = 'sproc_sch_student_list';

        $iparams = [
            '-iparam_filter_type',
            ':iparam_filter_entity_id',
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
}
