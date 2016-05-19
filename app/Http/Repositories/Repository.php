<?php

namespace App\Http\Repositories;

use DB;

class Repository
{

    public function db()
    {
        return DB::connection('secondDB');
    }

    public function runProcedure($model, $procedure, $iparams, $oparams)
    {
        // generate the sql for the procedure call
        $procedureSql = $this->generateProcedureSql($procedure, $iparams, $oparams);

        // prepare the procedure
        $pdo = $this->db()->getPdo();
        $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);

        $dbCall = $pdo->prepare($procedureSql);

        // debug code
        $debugIParams = [];

        // bind the input parameters
        foreach ($iparams as $parameter) {
            if (strpos($parameter, 'iparm_') !== false) {
                $property = substr($parameter, 7);
            } else {
                $property = substr($parameter, 8);
            }
            $dbCall->bindValue($parameter, $model->{$property});

            // debug code
            $debugIParams[$parameter] = $model->{$property};
        }

        // debug code
        session()->put('debug-info-procedure', $procedure);
        session()->put('debug-info-iparams', $debugIParams);

        // execute procedure
        $dbCall->execute();
        $dbCall->closeCursor();

        // generate sql for output params and execute it
        $outputSql = $this->generateOutputSql($oparams);
        $response = $pdo->query($outputSql)->fetch(\PDO::FETCH_ASSOC);


        // debug code
        $debugOParams = [];

        // set output params on the model
        foreach ($oparams as $oparam) {
            if (isset($response[$oparam])) {
                $property = substr($oparam, 8);
                $model->setAttribute($property, $response[$oparam]);

                // debug code
                $debugOParams[$property] = $response[$oparam];
            }
        }

        // debug code
        session()->put('debug-info-oparams', $debugOParams);


        if ($response['@oparam_err_flag'] == null) {
            return true;
        }

        $model->errors = $response['@oparam_err_msg'];
        return false;
    }

    /**
     * Generate sql to select procedure output parameters.
     *
     * @param  array $oparams
     * @return string
     */
    public function generateOutputSql($oparams)
    {
        return 'SELECT ' . implode(', ', $oparams);
    }

    /**
     * Generate sql for procedure with input parameters.
     *
     * @param  array $oparams
     * @return string
     */
    public function generateProcedureSql($procedure, $iparams, $oparams)
    {
        $sql = 'call ' . $procedure . '(';
        $sql .= implode(', ', $iparams);
        $sql .= ', ';
        $sql .= implode(', ', $oparams);
        $sql .= ');';
        return $sql;
    }

    public function getAdmissionGrid()
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

    public function getProducts()
    {
        return $this->db()->select(
            'SELECT product, product_type, unit_rate, product_type_entity_id, product_entity_id, active
             FROM view_prd_lkp_product
             ORDER BY product DESC;'
        );
    }

    public function getProductTypes()
    {
        return $this->db()->select(
            'SELECT product_type_entity_id, product_type
             FROM view_prd_lkp_product_type
             ORDER BY product_type;'
        );
    }

    public function getClassSubjectsGrid()
    {
        return $this->db()->select(
            'SELECT class_name, subject, mapped, class_entity_id, subject_entity_id, class_reporting_order, subject_reporting_order
            FROM view_sch_class2subject_grid
            ORDER BY class_reporting_order, subject_reporting_order DESC;'
        );
    }

    public function getAdjustmentType()
    {
        return $this->db()->select(
            'SELECT payment_type_id, payment_type
            FROM view_act_lkp_adjustment_type
            ORDER BY payment_type DESC;'
        );
    }

    public function getPaymentType()
    {
        return $this->db()->select(
            'SELECT payment_type_id, payment_type
            FROM view_act_lkp_payment_type
            ORDER BY payment_type DESC;'
        );
    }

    public function getScheduleDetail()
    {
        return $this->db()->select(
            'SELECT schedule_entity_id, entity_type_id, subject_entity_id, product_entity_id, frequency_id, due_date_days_value, schedule_name, start_date, end_date, amount
            FROM view_act_rcv_schedule_detail
            ORDER BY schedule_name DESC;'
        );
    }

    public function getAccountType4ReceivablePayment()
    {
        return $this->db()->select(
            'SELECT row_type, primary_key_id, drop_down_list_name, sequence_id
            FROM view_org_lkp_account_type_4_receivable_payment
            ORDER BY drop_down_list_name DESC;'
        );
    }

    public function getScheduleGrid()
    {
        return $this->db()->select(
            'SELECT schedule_name, subject_name, product_name, frequency, start_date, end_date, amount, schedule_entity_id, active
            FROM view_act_rcv_schedule_grid
            ORDER BY schedule_name DESC;'
        );
    }

    public function getSchedulePaymentDetail()
    {
        return $this->db()->select(
            'SELECT schedule_entity_id, entity_type_id, subject_entity_id, product_entity_id, frequency_id, due_date_days_value, schedule_name, start_date, end_date, amount
            FROM view_act_schedule_payment_detail
            ORDER BY schedule_name DESC;'
        );
    }

    public function getRcvSchedulePaymentDetail()
    {
        return $this->db()->select(
            'SELECT schedule_entity_id, entity_type_id, subject_entity_id, product_entity_id, frequency_id, due_date_days_value, schedule_name, start_date, end_date, amount
            FROM view_act_rcv_schedule_payment_detail
            ORDER BY schedule_name DESC;'
        );
    }

    public function getActRcvSchedulePaymentGrid()
    {
        return $this->db()->select(
            'SELECT schedule_name, subject_name, product_name, frequency, start_date, end_date, amount, schedule_entity_id, active
            FROM view_act_rcv_schedule_payment_grid
            ORDER BY schedule_name DESC;'
        );
    }

    public function getSchedulePaymentGrid()
    {
        return $this->db()->select(
            'SELECT schedule_name, subject_name, product_name, frequency, start_date, end_date, amount, schedule_entity_id, active
            FROM view_act_schedule_payment_grid
            ORDER BY schedule_name DESC;'
        );
    }

    public function getEntityScope()
    {
        return $this->db()->select(
            'SELECT entity_id, facility_entity_id
            FROM view_org_entity_scope;'
        );
    }

    public function getFacilityLkp()
    {
        return $this->db()->select(
            'SELECT facility_entity_id, facility_name
            FROM view_org_facility_lkp
            ORDER BY facility_name DESC;'
        );
    }

    public function getFiscalYear()
    {
        return $this->db()->select(
            'SELECT fiscal_year_entity_id, fiscal_year, start_date, end_date, current_fiscal_year
            FROM view_org_fiscal_year
            ORDER BY fiscal_year DESC;'
        );
    }

    public function getFiscalYearDetail()
    {
        return $this->db()->select(
            'SELECT fiscal_year_entity_id, fiscal_year, start_date, end_date, current_fiscal_year
            FROM view_org_fiscal_year_detail
            ORDER BY fiscal_year DESC;'
        );
    }

    public function getAccountType()
    {
        return $this->db()->select(
            'SELECT entity_type_id, entity_type
            FROM view_org_lkp_account_type
            ORDER BY entity_type DESC;'
        );
    }

    public function getAddressType()
    {
        return $this->db()->select(
            'SELECT address_type_id, address_type
            FROM view_org_lkp_address_type
            ORDER BY address_type DESC;'
        );
    }

    public function getCategoryType()
    {
        return $this->db()->select(
            'SELECT category_type_id, category_name, entity_type_id, entity_type
            FROM view_org_lkp_category_type
            ORDER BY category_name DESC;'
        );
    }

    public function getClient()
    {
        return $this->db()->select(
            'SELECT entity_name, city, city_area
            FROM view_org_lkp_client
            ORDER BY entity_name DESC;'
        );
    }

    public function getDistrict()
    {
        return $this->db()->select(
            'SELECT district
            FROM view_org_lkp_district
            ORDER BY district DESC;'
        );
    }

    public function getEntityName()
    {
        return $this->db()->select(
            'SELECT entity_name, entity_type_id, entity_id
            FROM view_org_lkp_entity_name
            ORDER BY entity_name DESC;'
        );
    }

    public function getEntityType()
    {
        return $this->db()->select(
            'SELECT entity_type_id, entity_type
            FROM view_org_lkp_entity_type
            ORDER BY entity_type DESC;'
        );
    }


    public function getFrequency()
    {
        return $this->db()->select(
            'SELECT frequency_id, description
            FROM view_org_lkp_frequency
            ORDER BY frequency_id DESC;'
        );
    }

    public function getIndividual()
    {
        return $this->db()->select(
            'SELECT individual_entity_id, individual_name, entity_type_id, entity_type
            FROM view_org_lkp_individual
            ORDER BY individual_name DESC;'
        );
    }

    public function getOrganizationType()
    {
        return $this->db()->select(
            'SELECT organization_type, organization_type_id
            FROM view_org_lkp_organization_type
            ORDER BY organization_type DESC;'
        );
    }

    public function getState()
    {
        return $this->db()->select(
            'SELECT state
            FROM view_org_lkp_state
            ORDER BY state DESC;'
        );
    }

    public function getOrganizationDetail()
    {
        return $this->db()->select(
            'SELECT organization_name, work_phone, mobile_phone, email, address1, address2, city_area, postal_code, city_id, organization_type_id, organization_entity_id
            FROM view_org_organization_detail
            ORDER BY organization_name DESC;'
        );
    }

    public function getOrganizationGrid()
    {
        return $this->db()->select(
            'SELECT organization_name, organization_type, mobile_phone, organization_entity_id
            FROM view_org_organization_grid
            ORDER BY organization_name DESC;'
        );
    }

    public function getAdmissionDetail()
    {
        return $this->db()->select(
            'SELECT admission_id, student_first_name, student_middle_name, student_last_name, student_date_of_birth, student_gender, admission_number, admission_date, admitted_to_class_group, admitted_to_class, current_class, student_roll_number, identification1, identification2, caste_name, religion_name, mother_language_name, home_phone, mobile_phone, email, address1, address2, city_name, city_area, postal_code, parent_relationship_type, parent_gender, parent_first_name, parent_middle_name, parent_last_name, parent_designation_name, parent_date_of_birth, facility_entity_id, admission_status_id, move_error, deleted, created_user_id, created_date, modified_user_id, modified_date, fiscal_year_entity_id, current_class_entity_id, parent_relationship_type_id, admitted_to_class_group_entity_id, admitted_to_class_entity_id
            FROM view_sch_admission_detail
            ORDER BY student_last_name DESC;'
        );
    }

    public function getClassDetail()
    {
        return $this->db()->select(
            'SELECT class_entity_id, class_name, description, reporting_order, class_category_entity_id, class_group_entity_id, facility_entity_id, active
            FROM view_sch_class_detail
            ORDER BY class_name DESC;'
        );
    }

    public function getClassGrid()
    {
        return $this->db()->select(
            'SELECT class_entity_id, class_name, class_group, class_category, class_group_entity_id, class_category_entity_id
            FROM view_sch_class_grid
            ORDER BY class_name DESC;'
        );
    }

    public function getGenerateProgressGrid()
    {
        return $this->db()->select(
            'SELECT class_name, subject, locked, progress_status, last_upload_modified_date, exam_entity_id, class_entity_id, subject_entity_id
            FROM view_sch_generate_progress_grid
            ORDER BY class_name DESC;'
        );
    }

    public function getAdmissionStatus()
    {
        return $this->db()->select(
            'SELECT admission_status_id, admission_status
            FROM view_sch_lkp_admission_status
            ORDER BY admission_status DESC;'
        );
    }

    public function getClassCategory()
    {
        return $this->db()->select(
            'SELECT class_category_entity_id, class_category
            FROM view_sch_lkp_class_category
            ORDER BY class_category DESC;'
        );
    }

    public function getExam()
    {
        return $this->db()->select(
            'SELECT exam, exam_type, exam_entity_id
            FROM view_sch_lkp_exam
            ORDER BY exam_type DESC;'
        );
    }

    public function getStudents()
    {
        return $this->db()->select(
            'SELECT student_full_name, first_name, middle_name, last_name, class_name, student_roll_number, fiscal_year, mobile_phone, active, class_student_id, student_entity_id, class_entity_id, class_category_entity_id, class_group_entity_id, fiscal_year_entity_id
            FROM view_sch_lkp_student
            ORDER BY student_full_name DESC;'
        );
    }

    public function getSubject()
    {
        return $this->db()->select(
            'SELECT subject, subject_entity_id
            FROM view_sch_lkp_subject
            ORDER BY subject DESC;'
        );
    }

    public function getMarkSheetDetail()
    {
        return $this->db()->select(
            'SELECT student_roll_number, student_full_name, student_marks, class_entity_id, subject_entity_id, exam_entity_id, class_student_id, marksheet_id
            FROM view_sch_mark_sheet_detail
            ORDER BY student_full_name DESC;'
        );
    }

    public function getMarkSheetGrid()
    {
        return $this->db()->select(
            'SELECT class_name, subject, locked, progress_status, last_upload_modified_date, exam_entity_id, class_entity_id, subject_entity_id
            FROM view_sch_mark_sheet_grid
            ORDER BY class_name DESC;'
        );
    }

    public function getMoveStudentGrid()
    {
        return $this->db()->select(
            'SELECT entity_name, student_roll_number, move_success_flag, facility_entity_id, class_entity_id, fiscal_year_entity_id
            FROM view_sch_move_student_grid
            ORDER BY entity_name DESC;'
        );
    }

    public function getProgressPrint()
    {
        return $this->db()->select(
            'SELECT exam_entity_id, class_entity_id, class_student_id, max_total_marks, student_total_marks, score_percent, rank, grade, pass_fail, student_full_name, student_roll_number, exam
            FROM view_sch_progress_print
            ORDER BY exam_entity_id DESC;'
        );
    }

    public function getScheduleExamGrid()
    {
        return $this->db()->select(
            'SELECT class_name, class_entity_id, subject_entity_id, subject, exam_date, exam_time, max_marks, class_subject_id, exam_entity_id
            FROM view_sch_schedule_exam_grid
            ORDER BY class_name DESC;'
        );
    }

    public function getStudentDetail()
    {
        return $this->db()->select(
            'SELECT first_name, middle_name, last_name, gender, date_of_birth, class_name, student_roll_number, fiscal_year, admission_number, admission_date, identification1, identification2, parent_first_name, parent_middle_name, parent_last_name, parent_relationship, caste_name, religion_name, mother_tounge, mobile_phone, home_phone, email, address1, address2, city_name, postal_code, class_student_id, student_entity_id, class_entity_id, fiscal_year_entity_id
            FROM view_sch_student_detail
            ORDER BY last_name DESC;'
        );
    }

    public function getUser()
    {
        return $this->db()->select(
            'SELECT user_id, login_name
            FROM view_sec_lkp_user
            ORDER BY login_name DESC;'
        );
    }

    public function getSmsType()
    {
        return $this->db()->select(
            'SELECT sms_type, sms_type_id
            FROM view_sms_lkp_sms_type
            ORDER BY sms_type DESC;'
        );
    }
}
