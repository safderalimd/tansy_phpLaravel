<?php

namespace App\Http\Modules\Organization\Repositories;

use App\Http\Repositories\Repository;

class AccountStudentRepository extends Repository
{

    // view_sch_lkp_student
    // view_sch_student_detail
    // view_org_lkp_facility
    // view_org_lkp_city
    // view_org_lkp_city_area
    // view_sch_lkp_class_group
    // view_sch_lkp_class
    // view_org_lkp_caste
    // view_org_lkp_religion
    // view_org_lkp_language
    // view_org_lkp_relationship
    // view_org_lkp_designation



    // sproc_org_account_student_dml_upd
    // sproc_org_account_student_dml_del

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
}

