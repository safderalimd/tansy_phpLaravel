<?php

namespace App\Http\Modules\reports\Accounting\Repositories;

use App\Http\Repositories\Repository;
use App\Http\Models\Model;

class AccountStatementRepository extends Repository
{
    public function getStudentById($id)
    {
        return $this->select(
            'SELECT
                student_entity_id,
                student_full_name,
                first_name AS student_first_name,
                middle_name AS student_middle_name,
                last_name AS student_last_name,
                gender AS student_gender,
                date_of_birth AS student_date_of_birth,
                email,
                home_phone,
                mobile_phone,
                address1,
                address2,
                city_name,
                postal_code,
                admission_number,
                admission_date,
                class_entity_id AS admitted_class_entity_id,
                identification1,
                identification2,
                caste_name,
                religion_name,
                mother_tounge,
                parent_full_name,
                parent_first_name,
                parent_middle_name,
                parent_last_name,
                class_name,
                student_roll_number,
                fiscal_year,
                parent_relationship,
                class_student_id,
                fiscal_year_entity_id,
                facility_entity_id,
                active,
                city_id,
                caste_id,
                religion_id,
                mother_language_id,
                parent_relationship_type_id,
                parent_designation_id,
                parent_gender,
                city_area
            FROM view_sch_student_detail
            WHERE student_entity_id = :id
            LIMIT 1;', ['id' => $id]
        );
    }

    public function getReceiptHeaderByStudent($id)
    {
        $model = new Model;
        $model->setAttribute('paid_by_account_id', $id);

        $procedure = 'sproc_act_rcv_receipt_header';

        $iparams = [
            ':iparam_receipt_id',
            ':iparam_paid_by_account_id',
        ];

        $oparams = [];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }
}
