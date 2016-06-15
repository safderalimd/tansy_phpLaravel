<?php

namespace App\Http\Repositories;

use DB;
use App\Http\Models\Model;

class Repository
{
    public function db()
    {
        return DB::connection('secondDB');
    }

    public function select()
    {
        $args = func_get_args();
        return call_user_func_array([$this->db(),'select'], $args);
    }

    /**
     * Procedure that also reads multiple data sets
     */
    public function procedure(Model $model, $procedure, $iparams = [], $oparams = [])
    {
        $procedure = new Procedure($this, $model, $procedure, $iparams, $oparams);
        return $procedure->run();
    }

    public function getAdmissionGrid()
    {
        return $this->select(
            'SELECT student_full_name, admission_number, admission_date, admitted_to, admission_status, admission_id, admission_status_id
             FROM view_sch_admission_grid
             ORDER BY student_full_name ASC;'
        );
    }

    public function getFiscalYears()
    {
        return $this->select(
            'SELECT fiscal_year_entity_id, fiscal_year
             FROM view_org_lkp_fiscal_year
             ORDER BY fiscal_year ASC;'
        );
    }

    public function getClasses()
    {
        return $this->select(
            'SELECT class_entity_id, class_name, class_group, class_category, class_group_entity_id, class_category_entity_id, class_reporting_order
             FROM view_sch_lkp_class
             ORDER BY class_reporting_order ASC;'
        );
    }

    public function getFacilities()
    {
        return $this->select(
            'SELECT
                facility_entity_id,
                facility_name,
                organization_type,
                organization_entity_id,
                organization_type_id
             FROM view_org_lkp_facility
             ORDER BY facility_name ASC;'
        );
    }

    public function getFacilitiesForOwner()
    {
        return $this->select(
            'SELECT
                facility_entity_id,
                facility_name,
                organization_type,
                organization_entity_id,
                organization_type_id
             FROM view_org_lkp_facility
             WHERE organization_type = :type
             ORDER BY facility_name ASC;', ['type' => 'owner']
        );
    }

    public function getClassGroups()
    {
        return $this->select(
            'SELECT class_group_entity_id, class_group
             FROM view_sch_lkp_class_group
             ORDER BY class_group ASC;'
        );
    }

    public function getCities()
    {
        return $this->select(
            'SELECT city_id, city_name, district, state, country
             FROM view_org_lkp_city
             ORDER BY city_name ASC;'
        );
    }

    public function getCityAreas()
    {
        return $this->select(
            'SELECT city_area
             FROM view_org_lkp_city_area
             ORDER BY city_area ASC;'
        );
    }

    public function getCastes()
    {
        return $this->select(
            'SELECT caste_id, caste_name
             FROM view_org_lkp_caste
             ORDER BY caste_name ASC;'
        );
    }

    public function getReligions()
    {
        return $this->select(
            'SELECT religion_id, religion_name
             FROM view_org_lkp_religion
             ORDER BY religion_name ASC;'
        );
    }

    public function getLanguages()
    {
        return $this->select(
            'SELECT language_id, language_name
             FROM view_org_lkp_language
             ORDER BY language_name ASC;'
        );
    }

    public function getRelationships()
    {
        return $this->select(
            'SELECT relationship_type_id, relationship_name
             FROM view_org_lkp_relationship
             ORDER BY relationship_name ASC;'
        );
    }

    public function getDesignations()
    {
        return $this->select(
            'SELECT designation_id, designation_name
             FROM view_org_lkp_designation
             ORDER BY designation_name ASC;'
        );
    }

    public function getProducts()
    {
        return $this->select(
            'SELECT product, product_type, unit_rate, product_type_entity_id, product_entity_id, active
             FROM view_prd_lkp_product
             ORDER BY product ASC;'
        );
    }

    public function getProductTypes()
    {
        return $this->select(
            'SELECT product_type_entity_id, product_type
             FROM view_prd_lkp_product_type
             ORDER BY product_type;'
        );
    }

    public function getClassSubjectsGrid()
    {
        return $this->select(
            'SELECT class_name, subject, mapped, class_entity_id, subject_entity_id, class_reporting_order, subject_reporting_order
            FROM view_sch_class2subject_grid
            ORDER BY class_reporting_order, subject_reporting_order ASC;'
        );
    }

    public function getAdjustmentType()
    {
        return $this->select(
            'SELECT payment_type_id, payment_type
            FROM view_act_lkp_adjustment_type
            ORDER BY payment_type ASC;'
        );
    }

    public function getPaymentType()
    {
        return $this->select(
            'SELECT payment_type_id, payment_type
            FROM view_act_lkp_payment_type
            ORDER BY payment_type ASC;'
        );
    }

    public function getAccountType4ReceivablePayment()
    {
        return $this->select(
            'SELECT row_type, primary_key_id, drop_down_list_name, sequence_id
            FROM view_org_lkp_account_type_4_receivable_payment
            ORDER BY drop_down_list_name ASC;'
        );
    }

    public function getScheduleGrid()
    {
        return $this->select(
            'SELECT schedule_name, subject_name, product_name, frequency, start_date, end_date, amount, schedule_entity_id, active
            FROM view_act_rcv_schedule_grid
            ORDER BY end_date DESC, product_name ASC;'
        );
    }

    public function getSchedulePaymentDetail()
    {
        return $this->select(
            'SELECT schedule_entity_id, entity_type_id, subject_entity_id, product_entity_id, frequency_id, due_date_days_value, schedule_name, start_date, end_date, amount
            FROM view_act_schedule_payment_detail
            ORDER BY schedule_name ASC;'
        );
    }

    public function getRcvSchedulePaymentDetail()
    {
        return $this->select(
            'SELECT schedule_entity_id, entity_type_id, subject_entity_id, product_entity_id, frequency_id, due_date_days_value, schedule_name, start_date, end_date, amount
            FROM view_act_rcv_schedule_payment_detail
            ORDER BY schedule_name ASC;'
        );
    }

    public function getActRcvSchedulePaymentGrid()
    {
        return $this->select(
            'SELECT schedule_name, subject_name, product_name, frequency, start_date, end_date, amount, schedule_entity_id, active
            FROM view_act_rcv_schedule_payment_grid
            ORDER BY schedule_name ASC;'
        );
    }

    public function getSchedulePaymentGrid()
    {
        return $this->select(
            'SELECT schedule_name, subject_name, product_name, frequency, start_date, end_date, amount, schedule_entity_id, active
            FROM view_act_schedule_payment_grid
            ORDER BY schedule_name ASC;'
        );
    }

    public function getEntityScope()
    {
        return $this->select(
            'SELECT entity_id, facility_entity_id
            FROM view_org_entity_scope;'
        );
    }

    public function getFacilityLkp()
    {
        return $this->select(
            'SELECT facility_entity_id, facility_name
            FROM view_org_facility_lkp
            ORDER BY facility_name ASC;'
        );
    }

    public function getFiscalYear()
    {
        return $this->select(
            'SELECT fiscal_year_entity_id, fiscal_year, start_date, end_date, current_fiscal_year
            FROM view_org_fiscal_year
            ORDER BY fiscal_year ASC;'
        );
    }

    public function getFiscalYearDetail()
    {
        return $this->select(
            'SELECT fiscal_year_entity_id, fiscal_year, start_date, end_date, current_fiscal_year
            FROM view_org_fiscal_year_detail
            ORDER BY fiscal_year ASC;'
        );
    }

    public function getAccountType()
    {
        return $this->select(
            'SELECT entity_type_id, entity_type
            FROM view_org_lkp_account_type
            ORDER BY entity_type ASC;'
        );
    }

    public function getAddressType()
    {
        return $this->select(
            'SELECT address_type_id, address_type
            FROM view_org_lkp_address_type
            ORDER BY address_type ASC;'
        );
    }

    public function getCategoryType()
    {
        return $this->select(
            'SELECT category_type_id, category_name, entity_type_id, entity_type
            FROM view_org_lkp_category_type
            ORDER BY category_name ASC;'
        );
    }

    public function getClient()
    {
        return $this->select(
            'SELECT entity_name, city, city_area
            FROM view_org_lkp_client
            ORDER BY entity_name ASC;'
        );
    }

    public function getDistrict()
    {
        return $this->select(
            'SELECT district
            FROM view_org_lkp_district
            ORDER BY district ASC;'
        );
    }

    public function getEntityName()
    {
        return $this->select(
            'SELECT entity_name, entity_type_id, entity_id
            FROM view_org_lkp_entity_name
            ORDER BY entity_name ASC;'
        );
    }

    public function getEntityType()
    {
        return $this->select(
            'SELECT entity_type_id, entity_type
            FROM view_org_lkp_entity_type
            ORDER BY entity_type ASC;'
        );
    }


    public function getFrequency()
    {
        return $this->select(
            'SELECT frequency_id, description
            FROM view_org_lkp_frequency
            ORDER BY description ASC;'
        );
    }

    public function getIndividual()
    {
        return $this->select(
            'SELECT individual_entity_id, individual_name, entity_type_id, entity_type
            FROM view_org_lkp_individual
            ORDER BY individual_name ASC;'
        );
    }

    public function getOrganizationType()
    {
        return $this->select(
            'SELECT organization_type, organization_type_id
            FROM view_org_lkp_organization_type
            ORDER BY organization_type ASC;'
        );
    }

    public function getState()
    {
        return $this->select(
            'SELECT state
            FROM view_org_lkp_state
            ORDER BY state ASC;'
        );
    }

    public function getOrganizationDetail()
    {
        return $this->select(
            'SELECT organization_name, work_phone, mobile_phone, email, address1, address2, city_area, postal_code, city_id, organization_type_id, organization_entity_id
            FROM view_org_organization_detail
            ORDER BY organization_name ASC;'
        );
    }

    public function getOrganizationGrid()
    {
        return $this->select(
            'SELECT organization_name, organization_type, mobile_phone, organization_entity_id
            FROM view_org_organization_grid
            ORDER BY organization_name ASC;'
        );
    }

    public function getAdmissionDetail()
    {
        return $this->select(
            'SELECT admission_id, student_first_name, student_middle_name, student_last_name, student_date_of_birth, student_gender, admission_number, admission_date, admitted_to_class_group, admitted_to_class, current_class, student_roll_number, identification1, identification2, caste_name, religion_name, mother_language_name, home_phone, mobile_phone, email, address1, address2, city_name, city_area, postal_code, parent_relationship_type, parent_gender, parent_first_name, parent_middle_name, parent_last_name, parent_designation_name, parent_date_of_birth, facility_entity_id, admission_status_id, move_error, deleted, created_user_id, created_date, modified_user_id, modified_date, fiscal_year_entity_id, current_class_entity_id, parent_relationship_type_id, admitted_to_class_group_entity_id, admitted_to_class_entity_id
            FROM view_sch_admission_detail
            ORDER BY student_last_name ASC;'
        );
    }

    public function getClassDetail()
    {
        return $this->select(
            'SELECT class_entity_id, class_name, description, reporting_order, class_category_entity_id, class_group_entity_id, facility_entity_id, active
            FROM view_sch_class_detail
            ORDER BY class_name ASC;'
        );
    }

    public function getClassGrid()
    {
        return $this->select(
            'SELECT class_entity_id, class_name, class_group, class_category, class_group_entity_id, class_category_entity_id
            FROM view_sch_class_grid
            ORDER BY class_name ASC;'
        );
    }

    public function getGenerateProgressGrid()
    {
        return $this->select(
            'SELECT class_name, subject, locked, progress_status, last_upload_modified_date, exam_entity_id, class_entity_id, subject_entity_id
            FROM view_sch_generate_progress_grid
            ORDER BY class_name ASC;'
        );
    }

    public function getAdmissionStatus()
    {
        return $this->select(
            'SELECT admission_status_id, admission_status
            FROM view_sch_lkp_admission_status
            ORDER BY admission_status ASC;'
        );
    }

    public function getClassCategory()
    {
        return $this->select(
            'SELECT class_category_entity_id, class_category
            FROM view_sch_lkp_class_category
            ORDER BY class_category ASC;'
        );
    }

    public function getExam()
    {
        return $this->select(
            'SELECT exam, exam_type, exam_entity_id, reporting_order
            FROM view_sch_lkp_exam
            ORDER BY reporting_order ASC;'
        );
    }

    public function getStudents()
    {
        return $this->select(
            'SELECT student_full_name, first_name, middle_name, last_name, class_name, student_roll_number, fiscal_year, mobile_phone, active, class_student_id, student_entity_id, class_entity_id, class_category_entity_id, class_group_entity_id, fiscal_year_entity_id, class_reporting_order
            FROM view_sch_lkp_student
            ORDER BY class_reporting_order, student_full_name ASC;'
        );
    }

    public function getSubject()
    {
        return $this->select(
            'SELECT subject, subject_entity_id
            FROM view_sch_lkp_subject
            ORDER BY subject ASC;'
        );
    }

    public function getMarkSheetDetail()
    {
        return $this->select(
            'SELECT student_roll_number, student_full_name, student_marks, class_entity_id, subject_entity_id, exam_entity_id, class_student_id, marksheet_id
            FROM view_sch_mark_sheet_detail
            ORDER BY student_full_name ASC;'
        );
    }

    public function getMarkSheetGrid()
    {
        return $this->select(
            'SELECT class_name, subject, locked, progress_status, last_upload_modified_date, exam_entity_id, class_entity_id, subject_entity_id
            FROM view_sch_mark_sheet_grid
            ORDER BY class_name ASC;'
        );
    }

    public function getMoveStudentGrid()
    {
        return $this->select(
            'SELECT entity_name, student_roll_number, move_success_flag, facility_entity_id, class_entity_id, fiscal_year_entity_id
            FROM view_sch_move_student_grid
            ORDER BY entity_name ASC;'
        );
    }

    public function getProgressPrint()
    {
        return $this->select(
            'SELECT exam_entity_id, class_entity_id, class_student_id, max_total_marks, student_total_marks, score_percent, rank, grade, pass_fail, student_full_name, student_roll_number, exam
            FROM view_sch_progress_print
            ORDER BY exam_entity_id ASC;'
        );
    }

    public function getScheduleExamGrid()
    {
        return $this->select(
            'SELECT class_name, class_entity_id, subject_entity_id, subject, exam_date, exam_time, max_marks, class_subject_id, exam_entity_id
            FROM view_sch_schedule_exam_grid
            ORDER BY class_name ASC;'
        );
    }

    public function getStudentDetail()
    {
        return $this->select(
            'SELECT first_name, middle_name, last_name, gender, date_of_birth, class_name, student_roll_number, fiscal_year, admission_number, admission_date, identification1, identification2, parent_first_name, parent_middle_name, parent_last_name, parent_relationship, caste_name, religion_name, mother_tounge, mobile_phone, home_phone, email, address1, address2, city_name, postal_code, class_student_id, student_entity_id, class_entity_id, fiscal_year_entity_id
            FROM view_sch_student_detail
            ORDER BY last_name ASC;'
        );
    }

    public function getUser()
    {
        return $this->select(
            'SELECT user_id, login_name
            FROM view_sec_lkp_user
            ORDER BY login_name ASC;'
        );
    }

    public function getSmsType()
    {
        return $this->select(
            'SELECT sms_type, sms_type_id
            FROM view_sms_lkp_sms_type
            ORDER BY sms_type ASC;'
        );
    }

    public function getIdentifications()
    {
        return $this->select(
            'SELECT
                unique_key,
                unique_key_id,
                default_value
             FROM view_org_lkp_client_unique_key;'
        );
    }

    public function getIdentification($id)
    {
        return $this->select(
           'SELECT
               unique_key,
               unique_key_id,
               default_value
            FROM view_org_lkp_client_unique_key
            WHERE unique_key_id = :id
            LIMIT 1;', ['id' => $id]
        );
    }

    public function getSelectedFacilities($id)
    {
        return $this->select(
            'SELECT
                entity_id,
                facility_entity_id
             FROM view_org_entity_scope
             WHERE entity_id = :id
             ORDER BY entity_id, facility_entity_id;',
             ['id' => $id]
        );
    }

    public function getDocumentType()
    {
        return $this->select(
            'SELECT
                document_type_id,
                document_type
             FROM view_org_lkp_document_type;'
        );
    }

    public function getSecurityGroup()
    {
        return $this->select(
            'SELECT
                security_group,
                security_group_entity_id,
                system_value
             FROM view_sec_lkp_security_group;'
        );
    }

    public function getAccountTypeFilter()
    {
        return $this->select(
            'SELECT
                row_type,
                entity_id,
                drop_down_list_name,
                sequence_id,
                reporting_order
             FROM view_lkp_account_type_filter
             ORDER BY sequence_id, reporting_order ASC;'
        );
    }
}
