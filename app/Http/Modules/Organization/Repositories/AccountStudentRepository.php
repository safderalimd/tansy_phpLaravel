<?php

namespace App\Http\Modules\Organization\Repositories;

use App\Http\Repositories\Repository;

class AccountStudentRepository extends Repository
{
    public function getDropdownValues($sql)
    {
        if (empty($sql)) {
            return [];
        }
        return $this->select($sql);
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
            '-iparam_student_roll_number',
            '-iparam_login_name',
            '-iparam_password',
            ':iparam_login_active',
            ':iparam_view_default_facility_id',
            ':iparam_security_group_entity_id',
            '-iparam_custom_fields_list',
            '-iparam_parent_info_list',
            '-iparam_document_info_list',
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

    public function detail($model)
    {
        $procedure = 'sproc_sch_lst_student_detail';

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

