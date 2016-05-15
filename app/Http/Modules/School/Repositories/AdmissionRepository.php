<?php

namespace App\Http\Modules\School\Repositories;

use App\Http\Repositories\Repository;

class AdmissionRepository extends Repository
{
    public function getAll()
    {
        return $this->db()->select(
            'SELECT student_full_name, admission_number, admission_date, admitted_to, admission_status, admission_id, admission_status_id
             FROM view_sch_admission_grid
             ORDER BY student_full_name DESC;'
        );
    }

    public function getFiscalYears()
    {
        return $this->db()->select(
            'SELECT fiscal_year_entity_id, fiscal_year
             FROM view_org_lkp_fiscal_year
             ORDER BY fiscal_year DESC;'
        );
    }

    public function getClasses()
    {
        return $this->db()->select(
            'SELECT class_entity_id, class_name, class_group, class_category, class_group_entity_id, class_category_entity_id
             FROM view_sch_lkp_class
             ORDER BY class_name DESC;'
        );
    }

    public function getFacilities()
    {
        return $this->db()->select(
            'SELECT facility_entity_id, facility_name
             FROM view_org_lkp_facility
             ORDER BY facility_name DESC;'
        );
    }

    public function getClassGroups()
    {
        return $this->db()->select(
            'SELECT class_group_entity_id, class_group
             FROM view_sch_lkp_class_group
             ORDER BY class_group DESC;'
        );
    }

    public function getCities()
    {
        return $this->db()->select(
            'SELECT city_id, city_name, district, state, country
             FROM view_org_lkp_city
             ORDER BY city_name DESC;'
        );
    }

    public function getCityAreas()
    {
        return $this->db()->select(
            'SELECT city_area
             FROM view_org_lkp_city_area
             ORDER BY city_area DESC;'
        );
    }

    public function getCastes()
    {
        return $this->db()->select(
            'SELECT caste_id, caste_name
             FROM view_org_lkp_caste
             ORDER BY caste_name DESC;'
        );
    }

    public function getReligions()
    {
        return $this->db()->select(
            'SELECT religion_id, religion_name
             FROM view_org_lkp_religion
             ORDER BY religion_name DESC;'
        );
    }

    public function getLanguages()
    {
        return $this->db()->select(
            'SELECT language_id, language_name
             FROM view_org_lkp_language
             ORDER BY language_name DESC;'
        );
    }

    public function getRelationships()
    {
        return $this->db()->select(
            'SELECT relationship_type_id, relationship_name
             FROM view_org_lkp_relationship
             ORDER BY relationship_name DESC;'
        );
    }

    public function getDesignations()
    {
        return $this->db()->select(
            'SELECT designation_id, designation_name
             FROM view_org_lkp_designation
             ORDER BY designation_name DESC;'
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

}
