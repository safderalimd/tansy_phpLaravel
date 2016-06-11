<?php

namespace App\Http\Modules\reports\Accounting\Repositories;

use App\Http\Repositories\Repository;

class AccountStatementRepository extends Repository
{
    public function getStudentById($id)
    {
        return $this->select(
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
            FROM view_sch_student_detail;'
        );
            // WHERE student_entity_id = :id
            // LIMIT 1;', ['id' => $id]
    }

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

    public function getReceiptHeaderByStudent($id)
    {
        return $this->select(
            'SELECT
                receipt_id,
                receipt_number,
                receipt_date,
                receipt_amount,
                new_balance,
                paid_by_name,
                paid_by_account_id,
                financial_year_balance,
                mobile_phone
            FROM view_act_rcv_receipt_header
            WHERE paid_by_account_id = :id
            ORDER BY receipt_date ASC;', ['id' => $id]
        );
    }

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
