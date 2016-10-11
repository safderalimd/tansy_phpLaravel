<?php

namespace App\Http\Modules\reports\School\Repositories;

use App\Http\Repositories\Repository;
use App\Http\Models\Model;

class OneStudentRepository extends Repository
{
    public function getPdfData($id)
    {
        $model = new Model;
        $model->setAttribute('student_entity_id', $id);

        $procedure = 'sproc_sch_student_detail';

        $iparams = [
            ':iparam_student_entity_id',
        ];

        $oparams = [];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }
}
