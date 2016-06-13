<?php

namespace App\Http\Modules\reports\School\Repositories;

use App\Http\Repositories\Repository;

class StudentDetailRepository extends Repository
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
        return $this->select(
            'SELECT
                first_name,
                middle_name,
                last_name,
                student_full_name,
                gender,
                date_of_birth,
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
                class_entity_id,
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
                class_reporting_order
             FROM view_sch_student_detail
             WHERE student_entity_id = :id;',
             ['id' => $id]
        );
    }

    // Todo: filter this select
    public function getSchoolName()
    {
        return $this->select(
            'SELECT
                organization_name,
                work_phone,
                mobile_phone,
                email,
                address1,
                address2,
                city_area,
                postal_code,
                city_id,
                organization_type_id,
                organization_entity_id
            FROM view_org_organization_detail_owner
            LIMIT 1;'
        );
    }
}
