<?php

namespace App\Http\Modules\School\Repositories;

use App\Http\Repositories\Repository;

class AdmissionRepository extends Repository
{
    public function getDropdownValues($sql)
    {
        if (empty($sql)) {
            return [];
        }
        return $this->select($sql);
    }

    public function insert($model)
    {
        $procedure = 'sproc_sch_admission_dml_ins';

        $iparams = [
            ':iparam_facility_entity_id',
            '-iparam_student_first_name',
            '-iparam_student_middle_name',
            '-iparam_student_last_name',
            '-iparam_student_date_of_birth',
            '-iparam_student_gender',
            '-iparam_admission_number',
            '-iparam_admission_date',
            '-iparam_admitted_to_class_group_entity_id',
            '-iparam_student_roll_number',
            '-iparam_identification1',
            '-iparam_identification2',
            '-iparam_caste_name',
            '-iparam_religion_name',
            '-iparam_mother_language_name',
            '-iparam_home_phone',
            '-iparam_mobile_phone',
            '-iparam_email',
            '-iparam_address1',
            '-iparam_address2',
            '-iparam_city_name',
            '-iparam_city_area',
            '-iparam_postal_code',

            '-iparam_father_name',
            '-iparam_father_designation',
            '-iparam_father_qualification',
            '-iparam_mother_name',
            '-iparam_mother_designation',
            '-iparam_mother_qualification',
            '-iparam_guardian_name',
            '-iparam_guardian_designation',
            '-iparam_guardian_qualification',

            '-iparam_aadhar_card_number',
            '-iparam_pan_card_number',

            '-iparam_custom_fields_list',

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

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function update($model)
    {
        $procedure = 'sproc_sch_admission_dml_upd';

        $iparams = [
            ':iparam_admission_id',
            ':iparam_facility_entity_id',
            '-iparam_student_first_name',
            '-iparam_student_middle_name',
            '-iparam_student_last_name',
            '-iparam_student_date_of_birth',
            '-iparam_student_gender',
            '-iparam_admission_number',
            '-iparam_admission_date',
            ':iparam_admitted_to_class_group_entity_id',
            '-iparam_student_roll_number',
            '-iparam_identification1',
            '-iparam_identification2',
            '-iparam_caste_name',
            '-iparam_religion_name',
            '-iparam_mother_language_name',
            '-iparam_home_phone',
            '-iparam_mobile_phone',
            '-iparam_email',
            '-iparam_address1',
            '-iparam_address2',
            '-iparam_city_name',
            '-iparam_city_area',
            '-iparam_postal_code',

            '-iparam_father_name',
            '-iparam_father_designation',
            '-iparam_father_qualification',
            '-iparam_mother_name',
            '-iparam_mother_designation',
            '-iparam_mother_qualification',
            '-iparam_guardian_name',
            '-iparam_guardian_designation',
            '-iparam_guardian_qualification',

            '-iparam_aadhar_card_number',
            '-iparam_pan_card_number',

            '-iparam_custom_fields_list',

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

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function moveStudents($model)
    {
        $procedure = 'sproc_sch_admission_move_student_dml';

        $iparams = [
            ':iparam_move_to_class_entity_id',
            ':iparam_move_to_fiscal_year_entity_id',
            '-iparam_admission_ids',
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
        $procedure = 'sproc_sch_lst_admission_detail';

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

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }
}
