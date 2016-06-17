<?php

namespace App\Http\Modules\Organization\Repositories;

use App\Http\Repositories\Repository;

class AccountStudentRepository extends Repository
{
    public function getSecurityGroupForParent()
    {
        return $this->select(
            'SELECT
                security_group,
                security_group_entity_id,
                system_value
             FROM view_sec_lkp_security_group
             WHERE security_group = :group
             LIMIT 1;', ['group' => 'Parent']
        );
    }

    public function getModelById($id)
    {
        return $this->select(
            'SELECT
                first_name AS student_first_name,
                middle_name AS student_middle_name,
                last_name AS student_last_name,
                student_full_name,
                gender AS student_gender,
                date_of_birth AS student_date_of_birth,
                class_name,
                student_roll_number,
                fiscal_year,
                admission_number,
                admission_date,
                identification1,
                identification2,
                parent_first_name,
                parent_middle_name,
                parent_last_name,
                parent_full_name,
                parent_relationship,
                caste_name,
                religion_name,
                mother_tounge,
                mobile_phone,
                home_phone,
                email,
                address1,
                address2,
                city_name,
                city_area,
                postal_code,
                class_student_id,
                student_entity_id,
                class_entity_id AS admitted_class_entity_id,
                class_group_entity_id,
                class_category_entity_id,
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
                parent_designation_name,
                class_reporting_order,
                document_type_id,
                document_number,
                login_name,
                password,
                login_active,
                default_facility_id AS view_default_facility_id,
                group_entity_id AS security_group_entity_id
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
            '-iparam_student_first_name',
            '-iparam_student_middle_name',
            '-iparam_student_last_name',
            '-iparam_student_date_of_birth',
            '-iparam_student_gender',
            '-iparam_email',
            '-iparam_home_phone',
            '-iparam_mobile_phone',
            '-iparam_address1',
            '-iparam_address2',
            ':iparam_city_id',
            '-iparam_city_area',
            '-iparam_postal_code',
            '-iparam_admission_number',
            '-iparam_admission_date',
            ':iparam_admitted_class_entity_id',
            '-iparam_identification1',
            '-iparam_identification2',
            ':iparam_caste_id',
            ':iparam_religion_id',
            ':iparam_mother_language_id',
            ':iparam_parent_relationship_type_id',
            '-iparam_parent_first_name',
            '-iparam_parent_middle_name',
            '-iparam_parent_last_name',
            ':iparam_parent_designation_id',
            '-iparam_parent_gender',
            '-iparam_student_roll_number',
            ':iparam_document_type_id',
            '-iparam_document_number',
            '-iparam_login_name',
            '-iparam_password',
            ':iparam_login_active',
            ':iparam_view_default_facility_id',
            ':iparam_security_group_entity_id',
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

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }
}

