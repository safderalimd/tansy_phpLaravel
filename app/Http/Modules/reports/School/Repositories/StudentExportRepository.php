<?php

namespace App\Http\Modules\reports\School\Repositories;

use App\Http\Repositories\Repository;

class StudentExportRepository extends Repository
{
    public function getPdfData($column = null, $id = null)
    {
        $sql = 'SELECT
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
                class_reporting_order,
                document_number
            FROM view_sch_student_detail';

        if (!is_null($column) && !is_null($id)) {
            $sql .= ' WHERE '.$column.' = :id';
            $params = ['id' => $id];
        } else {
            $params = [];
        }
        $sql .= ' ORDER BY class_reporting_order, student_full_name ASC;';

        return $this->select($sql, $params);
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

    // public function getDropdown()
    // {
        // return $this->lookup('sproc_org_lkp_class_type_4_student_pdf_report');

        // return $this->select(
        //     'SELECT
        //         row_type,
        //         primary_key_id,
        //         drop_down_list_name,
        //         sequence_id
        //     FROM view_org_lkp_class_type_4_student_pdf_report
        //     ORDER BY drop_down_list_name;'
        // );
    // }

    public function getFilterCriteria($model)
    {
        $procedure = 'sproc_org_lkp_class_type_4_student_pdf_report';

        $data = $this->procedure($model, $procedure, [':iparam_primary_key_id'], []);
        return first_resultset($data);

        // return $this->select(
        //     'SELECT
        //         row_type,
        //         primary_key_id,
        //         drop_down_list_name,
        //         sequence_id
        //     FROM view_org_lkp_class_type_4_student_pdf_report
        //     WHERE primary_key_id = :id
        //     ORDER BY drop_down_list_name
        //     LIMIT 1;', ['id' => $id]
        // );
    }
}
