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

    public function lookup($procedure)
    {
        $data = $this->procedure(new Model, $procedure, [], []);
        return first_resultset($data);
    }

    public function getFiscalYears()
    {
        // fiscal_year_entity_id, fiscal_year
        return $this->lookup('sproc_org_lkp_fiscal_year');
    }

    public function getClasses()
    {
        // class_entity_id, class_name, class_group, class_category, class_group_entity_id, class_category_entity_id, class_reporting_order
        return $this->lookup('sproc_sch_lkp_class');
    }

    public function getTeachers()
    {
        // teacher_name, teacher_short_name, teacher_entity_id
        return $this->lookup('sproc_sch_lkp_teacher');
    }

    public function getPeriods()
    {
        // period_name, start_time, end_time, period_type,
        return $this->lookup('sproc_sch_lkp_periods');
    }

    public function getTimeTableFilter()
    {
        // entity_id, entity_name
        return $this->lookup('sproc_sch_lkp_time_table_filter');
    }

    public function getMonths()
    {
        // month_id, calendar_month
        return $this->lookup('sproc_org_lkp_current_fiscal_year_months');
    }

    public function getWeekDays()
    {
        // week_day_number, week_day, week_day_short_code
        return $this->lookup('sproc_org_lkp_week_days');
    }

    public function getEmployees()
    {
        // employee_name, employee_entity_id
        return $this->lookup('sproc_org_lkp_account_employee');
    }

    public function getOrgEmployees()
    {
        return $this->lookup('sproc_org_lkp_employee');
    }

    public function getFacilityTypes()
    {
        //  facility_type_id, facility_type
        return $this->lookup('sproc_org_lkp_facility_type');
    }

    public function getClassGroups()
    {
        // class_group_entity_id, class_group
        return $this->lookup('sproc_sch_lkp_class_group');
    }

    public function getCities()
    {
        // city_id, city_name, district, state, country
        return $this->lookup('sproc_org_lkp_city');
    }

    public function getCityAreas()
    {
        // city_area
        return $this->lookup('sproc_org_lkp_city_area_area');
    }

    public function getCastes()
    {
        // caste_id, caste_name
        return $this->lookup('sproc_org_lkp_caste');
    }

    public function getReligions()
    {
        // religion_id, religion_name
        return $this->lookup('sproc_org_lkp_religion');
    }

    public function getOrganizationSupplier()
    {
        // organization_name, organization_entity_id, organization_type
        return $this->lookup('sproc_org_lkp_organization_supplier');
    }

    public function getLanguages()
    {
        // language_id, language_name
        return $this->lookup('sproc_org_lkp_language');
    }

    public function getRelationships()
    {
        // relationship_type_id, relationship_name
        return $this->lookup('sproc_org_lkp_relationship');
    }

    public function getDesignations()
    {
        // designation_id, designation_name
        return $this->lookup('sproc_org_lkp_designation');
    }

    public function getQualifications()
    {
        // qualification_id, qualification_name
        return $this->lookup('sproc_org_lkp_qualification');
    }

    public function getProducts()
    {
        // product_name, product_entity_id
        return $this->lookup('sproc_prd_lkp_product');
    }

    public function getProductTypes()
    {
        // product_type_entity_id, product_type
        return $this->lookup('sproc_prd_lkp_product_type');
    }

    public function getProductRelease()
    {
        // product_release_name, product_release_id
        return $this->lookup('sproc_crm_lkp_product_release');
    }

    public function getAdjustmentType()
    {
        // payment_type_id, payment_type
        return $this->lookup('sproc_act_lkp_adjustment_type');
    }

    public function getExpenseTypes()
    {
        // expense_type, expense_type_id
        return $this->lookup('sproc_act_lkp_expense_type');
    }

    public function getPaymentTypes()
    {
        // payment_type_id, payment_type
        return $this->lookup('sproc_act_lkp_payment_type');
    }

    public function getStatuses()
    {
        // client_status, client_status_id
        return $this->lookup('sproc_crm_lkp_client_status');
    }

    public function getUnitTypes()
    {
        // unit_type_id, unit_type
        return $this->lookup('sproc_crm_lkp_unit_type');
    }

    public function getVisitType()
    {
        // visit_type_id, visit_type
        return $this->lookup('view_crm_lkp_visit_type');
    }

    public function getAccountType()
    {
        // entity_type_id, entity_type
        return $this->lookup('sproc_org_lkp_account_type');
    }

    public function getAddressType()
    {
        // address_type_id, address_type
        return $this->lookup('sproc_org_lkp_address_type');
    }

    public function getAgents()
    {
        // agent_name, individual_entity_id, mobile_phone, organization_entity_id
        return $this->lookup('sproc_org_lkp_agent');
    }

    public function getCampaigns()
    {
        // campaign_name, campaign_entity_id
        return $this->lookup('sproc_org_lkp_campaign');
    }

    public function getCategoryType()
    {
        // category_type_id, category_name, entity_type_id, entity_type
        return $this->lookup('sproc_org_lkp_category_type');
    }

    public function getClient()
    {
        // entity_name, city, city_area
        return $this->lookup('sproc_org_lkp_client');
    }

    public function getDistrict()
    {
        // district
        return $this->lookup('sproc_org_lkp_district');
    }

    public function getEntityName()
    {
        // entity_name, entity_type_id, entity_id
        return $this->lookup('sproc_org_lkp_entity_name');
    }

    public function getEntityType()
    {
        // entity_type_id, entity_type
        return $this->lookup('sproc_org_lkp_entity_type');
    }

    public function getFrequency()
    {
        // frequency_id, description
        return $this->lookup('sproc_org_lkp_frequency');
    }

    public function getIndividual()
    {
        // individual_entity_id, individual_name, entity_type_id, entity_type
        return $this->lookup('sproc_org_lkp_individual');
    }

    public function getOrganizationType()
    {
        // organization_type, organization_type_id
        return $this->lookup('sproc_org_lkp_organization_type');
    }

    public function getState()
    {
        // state
        return $this->lookup('sproc_org_lkp_state');
    }

    public function getAdmissionStatus()
    {
        // admission_status_id, admission_status
        return $this->lookup('sproc_sch_lkp_admission_status');
    }

    public function getClassCategories()
    {
        // class_category_entity_id, class_category
        return $this->lookup('sproc_sch_lkp_class_category');
    }

    public function getExam()
    {
        // exam, exam_type, exam_entity_id, reporting_order
        return $this->lookup('sproc_sch_lkp_exam');
    }

    public function getMainExam()
    {
        return $this->lookup('sproc_sch_lkp_main_exam');
    }

    public function getExamTypes()
    {
        // exam_type_id, exam_type
        return $this->lookup('sproc_sch_lkp_exam_type');
    }

    public function getExamWithResult()
    {
        // exam, exam_type, exam_entity_id, reporting_order
        return $this->lookup('sproc_sch_lkp_exam_with_result');
    }

    public function getSubject()
    {
        // subject, subject_entity_id
        return $this->lookup('sproc_sch_lkp_subject');
    }

    public function getSubjectTypes()
    {
        // subject_type_id, subject_type
        return $this->lookup('sproc_sch_lkp_subject_type');
    }

    public function getUser()
    {
        // user_id, login_name
        return $this->lookup('sproc_sec_lkp_user');
    }

    public function getDocumentType()
    {
        // document_type_id, document_type
        return $this->lookup('sproc_org_lkp_document_type');
    }

    public function getGradeSystem()
    {
        return $this->lookup('sproc_sch_lkp_exam_grading_system');
    }

    public function getAccountTypeFilter3()
    {
        // entity_id, drop_down_list_name
        return $this->lookup('sproc_org_lkp_account_type_filter3');
    }

    public function getAccountTypeFilter()
    {
        // row_type, entity_id, drop_down_list_name
        return $this->lookup('sproc_org_lkp_account_type_filter2');
    }

    public function getSchoolAccountTypeFilter()
    {
        return $this->lookup('sproc_sch_lkp_account_type_filter');
    }

    public function getOwnerOrganization()
    {
        // organization_name, website, report_header_line2, report_header_line3
        return $this->lookup('sproc_org_lkp_report_header');
    }

    public function getIssueStatus()
    {
        // issue_status, issue_status_id
        return $this->lookup('sproc_crm_lkp_issue_status');
    }

    public function getDepartments()
    {
        // department_name, department_id, active
        return $this->lookup('sproc_org_lkp_department');
    }

    public function getOrganizations()
    {
        // organization_name, organization_entity_id
        $procedure = 'sproc_org_lkp_organization';
        $data = $this->procedure(new Model, $procedure, ['-iparam_organization_type'], []);
        return first_resultset($data);
    }

    public function getClientOrganizations()
    {
        // organization_name, organization_entity_id, organization_type
        $procedure = 'sproc_org_lkp_organization';
        $model = new Model;
        $model->setAttribute('organization_type', 'Client');
        $data = $this->procedure($model, $procedure, ['-iparam_organization_type'], []);
        return first_resultset($data);
    }

    public function getAgentOrganizations()
    {
        // organization_name, organization_entity_id, organization_type
        $procedure = 'sproc_org_lkp_organization';
        $model = new Model;
        $model->setAttribute('organization_type', 'Broker');
        $data = $this->procedure($model, $procedure, ['-iparam_organization_type'], []);
        return first_resultset($data);
    }

    public function getSecurityGroup()
    {
        // security_group, security_group_entity_id, system_value
        $procedure = 'sproc_sec_lkp_security_group';

        $iparams = [
            '-iparam_security_group',
            ':iparam_system_value',
        ];

        $data = $this->procedure(new Model, $procedure, $iparams, []);
        return first_resultset($data);
    }

    public function getSecurityGroupForParent()
    {
        // security_group, security_group_entity_id, system_value
        $procedure = 'sproc_sec_lkp_security_group';

        $iparams = [
            '-iparam_security_group',
            ':iparam_system_value',
        ];

        $model = new Model;
        $model->setAttribute('security_group', 'Parent');

        $data = $this->procedure($model, $procedure, $iparams, []);
        return first_resultset($data);
    }

    public function getSecurityGroupForAgent()
    {
        // security_group, security_group_entity_id, system_value
        $procedure = 'sproc_sec_lkp_security_group';

        $iparams = [
            '-iparam_security_group',
            ':iparam_system_value',
        ];

        $model = new Model;
        $model->setAttribute('security_group', 'Agent');

        $data = $this->procedure($model, $procedure, $iparams, []);
        return first_resultset($data);
    }

    public function getSecurityGroupForEmployees()
    {
        // security_group, security_group_entity_id, system_value
        $procedure = 'sproc_sec_lkp_security_group';

        $iparams = [
            '-iparam_security_group',
            ':iparam_system_value',
        ];

        $model = new Model;
        $model->setAttribute('system_value', 9);

        $data = $this->procedure($model, $procedure, $iparams, []);
        return first_resultset($data);
    }

    public function getStudents()
    {
        // student_full_name, first_name, middle_name, last_name, class_name, student_roll_number, fiscal_year, mobile_phone, active, class_student_id, student_entity_id, class_entity_id, class_category_entity_id, class_group_entity_id, fiscal_year_entity_id, class_reporting_order
        $procedure = 'sproc_sch_lkp_student';

        $iparams = [
            ':iparam_class_entity_id',
            ':iparam_student_entity_id',
            ':iparam_class_student_id',
        ];

        $data = $this->procedure(new Model, $procedure, $iparams, []);
        return first_resultset($data);
    }

    public function getIdentifications()
    {
        // unique_key, unique_key_id, default_value
        $procedure = 'sproc_org_lkp_client_unique_key';

        $data = $this->procedure(new Model, $procedure, [':iparam_unique_key_id'], []);
        return first_resultset($data);
    }

    public function getIdentification($id)
    {
        // unique_key, unique_key_id, default_value
        $procedure = 'sproc_org_lkp_client_unique_key';
        $model = new Model;
        $model->setAttribute('unique_key_id', $id);
        $data = $this->procedure($model, $procedure, [':iparam_unique_key_id'], []);
        return first_resultset($data);
    }

    public function getFacilities()
    {
        // facility_entity_id, facility_name, organization_type, organization_entity_id, organization_type_id
        $procedure = 'sproc_org_lkp_facility';

        $iparams = ['-iparam_organization_type'];

        $data = $this->procedure(new Model, $procedure, $iparams, []);
        return first_resultset($data);
    }

    public function getFacilitiesForOwner()
    {
        // facility_entity_id, facility_name, organization_type, organization_entity_id, organization_type_id
        $procedure = 'sproc_org_lkp_facility';

        $iparams = ['-iparam_organization_type'];

        $model = new Model;
        $model->setAttribute('organization_type', 'owner');

        $data = $this->procedure($model, $procedure, $iparams, []);
        return first_resultset($data);
    }

    public function getClassSubjectsGrid()
    {
        return $this->lookup('sproc_sch_class2subject_grid');
    }

    public function getScheduleGrid()
    {
        return $this->lookup('sproc_act_rcv_schedule_grid');
    }

    public function getSelectedFacilities($id)
    {
        $model = new Model;
        $model->setAttribute('entity_id', $id);

        $procedure = 'sproc_org_entity_scope';

        $iparams = [
            ':iparam_entity_id',
        ];

        $oparams = [];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }
}
