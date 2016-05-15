<?php

namespace App\Http\Modules\Organization\Repositories;

use App\Http\Repositories\Repository;

class AccountStudentRepository extends Repository
{
    public function getModelById($id)
    {
        return $this->db()->select(
            'SELECT
                student_entity_id,
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
                parent_first_name,
                parent_middle_name,
                parent_last_name,
                class_name,
                student_roll_number,
                fiscal_year,
                parent_relationship,
                class_student_id,
                fiscal_year_entity_id
            FROM view_sch_student_detail
            WHERE student_entity_id = :id
            LIMIT 1;', ['id' => $id]
        );
    }

    public function update($model)
    {
        $procedure = 'sproc_org_account_student_dml_upd';

        $iparams = [
            ':iparam_student_entity_id',
            ':iparam_facility_entity_id',
            ':iparam_active',
            ':iparam_student_first_name',
            ':iparam_student_middle_name',
            ':iparam_student_last_name',
            ':iparam_student_date_of_birth',
            ':iparam_student_gender',
            ':iparam_email',
            ':iparam_home_phone',
            ':iparam_mobile_phone',
            ':iparam_address1',
            ':iparam_address2',
            ':iparam_city_id',
            ':iparam_city_area',
            ':iparam_postal_code',
            ':iparam_admission_number',
            ':iparam_admission_date',
            ':iparam_admitted_class_entity_id',
            ':iparam_identification1',
            ':iparam_identification2',
            ':iparam_caste_id',
            ':iparam_religion_id',
            ':iparam_mother_language_id',
            ':iparam_parent_relationship_type_id',
            ':iparam_parent_first_name',
            ':iparam_parent_middle_name',
            ':iparam_parent_last_name',
            ':iparam_parent_designation_id',
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

        return $this->runProcedure($model, $procedure, $iparams, $oparams);
    }

    public function delete($model)
    {
        $procedure = 'sproc_org_account_student_dml_del';

        $iparams = [
            ':iparam_student_entity_id',
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

        return $this->runProcedure($model, $procedure, $iparams, $oparams);
    }
}

