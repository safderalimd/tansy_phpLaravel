<?php

namespace App\Http\Modules\School\Repositories;

use App\Http\Repositories\Repository;

class AdmissionRepository extends Repository
{
    public function getModelById($id)
    {
        return $this->db()->select(
            'SELECT
                admission_id,
                student_first_name,
                student_middle_name,
                student_last_name,
                student_date_of_birth,
                student_gender,
                admission_number,
                admission_date,
                admitted_to_class_group,
                admitted_to_class,
                current_class,
                student_roll_number,
                identification1,
                identification2,
                caste_name,
                religion_name,
                mother_language_name,
                home_phone,
                mobile_phone,
                email,
                address1,
                address2,
                city_name,
                city_area,
                postal_code,
                parent_relationship_type,
                parent_gender,
                parent_first_name,
                parent_middle_name,
                parent_last_name,
                parent_designation_name,
                parent_date_of_birth,
                facility_entity_id,
                admission_status_id,
                move_error,
                deleted,
                created_user_id,
                created_date,
                modified_user_id,
                modified_date,
                fiscal_year_entity_id,
                current_class_entity_id,
                parent_relationship_type_id,
                admitted_to_class_group_entity_id,
                admitted_to_class_entity_id
             FROM view_sch_admission_detail
             WHERE admission_id = :id
             LIMIT 1;', ['id' => $id]
        );
    }

    public function insert($model)
    {
        $procedure = 'sproc_sch_admission_dml_ins';

        $iparams = [
            ':iparam_facility_entity_id',
            ':iparam_student_first_name',
            ':iparam_student_middle_name',
            ':iparam_student_last_name',
            ':iparam_student_date_of_birth',
            ':iparam_student_gender',
            ':iparam_admission_number',
            ':iparam_admission_date',
            ':iparam_admitted_to_class_group_entity_id',
            ':iparam_admitted_to_class_entity_id',
            ':iparam_student_roll_number',
            ':iparam_identification1',
            ':iparam_identification2',
            ':iparam_caste_name',
            ':iparam_religion_name',
            ':iparam_mother_language_name',
            ':iparam_home_phone',
            ':iparam_mobile_phone',
            ':iparam_email',
            ':iparam_address1',
            ':iparam_address2',
            ':iparam_city_name',
            ':iparam_city_area',
            ':iparam_postal_code',
            ':iparam_parent_relationship_type_id',
            ':iparam_parent_first_name',
            ':iparam_parent_last_name',
            ':iparam_parent_middle_name',
            ':iparam_parent_gender',
            ':iparam_parent_designation_name',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_admission_id',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->runProcedure($model, $procedure, $iparams, $oparams);
    }

    public function update($model)
    {
        $procedure = 'sproc_sch_admission_dml_upd';

        $iparams = [
            ':iparam_admission_id',
            ':iparam_facility_entity_id',
            ':iparam_student_first_name',
            ':iparam_student_middle_name',
            ':iparam_student_last_name',
            ':iparam_student_date_of_birth',
            ':iparam_student_gender',
            ':iparam_admission_number',
            ':iparam_admission_date',
            ':iparam_admitted_to_class_group_entity_id',
            ':iparam_admitted_to_class_entity_id',
            ':iparam_student_roll_number',
            ':iparam_identification1',
            ':iparam_identification2',
            ':iparam_caste_name',
            ':iparam_religion_name',
            ':iparam_mother_language_name',
            ':iparam_home_phone',
            ':iparam_mobile_phone',
            ':iparam_email',
            ':iparam_address1',
            ':iparam_address2',
            ':iparam_city_name',
            ':iparam_city_area',
            ':iparam_postal_code',
            ':iparam_parent_relationship_type',
            ':iparam_parent_first_name',
            ':iparam_parent_last_name',
            ':iparam_parent_middle_name',
            ':iparam_parent_gender',
            ':iparam_designation_name',
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
        $procedure = 'sproc_sch_admission_dml_del';

        $iparams = [
            ':iparam_admission_id',
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

    // set @iparam_move_to_class_entity_id = 31;
    // set @iparam_move_to_fiscal_year_entity_id = 56;
    // set @iparam_admission_ids = '81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100';
    public function moveStudent($model)
    {
        $procedure = 'sproc_sch_admission_move_student_dml';

        $iparams = [
            ':iparam_move_to_class_entity_id',
            ':iparam_move_to_fiscal_year_entity_id',
            ':iparam_admission_ids',
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
