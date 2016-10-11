<?php

namespace App\Http\Modules\reports\School\Repositories;

use App\Http\Repositories\Repository;
use App\Http\Models\Model;

class OneStudentRepository extends Repository
{
    public function getStudents()
    {
        return $this->select(
            'SELECT
                student_full_name,
                first_name,
                middle_name,
                last_name,
                class_name,
                student_roll_number,
                fiscal_year,
                mobile_phone,
                active,
                class_student_id,
                student_entity_id,
                class_entity_id,
                class_category_entity_id,
                class_group_entity_id,
                fiscal_year_entity_id,
                class_reporting_order
            FROM view_sch_lkp_student
            ORDER BY first_name ASC;'
        );
    }

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
