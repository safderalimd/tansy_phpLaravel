<?php

namespace App\Http\Modules\School\Repositories;

use DB;

class AdmissionRepository
{
    public function getAll()
    {
        return DB::connection('secondDB')->select(
            'SELECT student_full_name, admission_number, admission_date, admitted_to, admission_status, admission_id, admission_status_id
             FROM view_sch_admission_grid
             ORDER BY student_full_name DESC;'
        );
    }

    public function getFiscalYears()
    {
        return DB::connection('secondDB')->select(
            'SELECT fiscal_year_entity_id, fiscal_year
             FROM view_org_lkp_fiscal_year
             ORDER BY fiscal_year DESC;'
        );
    }

    public function getClasses()
    {
        return DB::connection('secondDB')->select(
            'SELECT class_entity_id, class_name, class_group, class_category, class_group_entity_id, class_category_entity_id
             FROM view_sch_lkp_class
             ORDER BY class_name DESC;'
        );
    }

    public function getFacilities()
    {
        return DB::connection('secondDB')->select(
            'SELECT facility_entity_id, facility_name
             FROM view_org_lkp_facility
             ORDER BY facility_name DESC;'
        );
    }

    public function getClassGroups()
    {
        return DB::connection('secondDB')->select(
            'SELECT class_group_entity_id, class_group
             FROM view_sch_lkp_class_group
             ORDER BY class_group DESC;'
        );
    }

    public function getCities()
    {
        return DB::connection('secondDB')->select(
            'SELECT city_id, city_name, district, state, country
             FROM view_org_lkp_city
             ORDER BY city_name DESC;'
        );
    }

    public function getCityAreas()
    {
        return DB::connection('secondDB')->select(
            'SELECT city_area
             FROM view_org_lkp_city_area
             ORDER BY city_area DESC;'
        );
    }

    public function getCastes()
    {
        return DB::connection('secondDB')->select(
            'SELECT caste_id, caste_name
             FROM view_org_lkp_caste
             ORDER BY caste_name DESC;'
        );
    }

    public function getReligions()
    {
        return DB::connection('secondDB')->select(
            'SELECT religion_id, religion_name
             FROM view_org_lkp_religion
             ORDER BY religion_name DESC;'
        );
    }

    public function getLanguages()
    {
        return DB::connection('secondDB')->select(
            'SELECT language_id, language_name
             FROM view_org_lkp_language
             ORDER BY language_name DESC;'
        );
    }

    public function getRelationships()
    {
        return DB::connection('secondDB')->select(
            'SELECT relationship_type_id, relationship_name
             FROM view_org_lkp_relationship
             ORDER BY relationship_name DESC;'
        );
    }

    public function getDesignations()
    {
        return DB::connection('secondDB')->select(
            'SELECT designation_id, designation_name
             FROM view_org_lkp_designation
             ORDER BY designation_name DESC;'
        );
    }



    // set @iparam_facility_entity_id  = 14;
    // set @iparam_student_first_name = 'Mohammed';
    // set @iparam_student_middle_name = 'Safder';
    // set @iparam_student_last_name = 'Ali';
    // set @iparam_student_date_of_birth  = '1976-1-1';
    // set @iparam_student_gender  = 'M';
    // set @iparam_admission_number  = 'A101';
    // set @iparam_admission_date  = '1990-1-30';
    // set @iparam_admitted_to_class_group_entity_id  = 18;
    // set @iparam_admitted_to_class_entity_id = null;
    // set @iparam_student_roll_number = null;
    // set @iparam_identification1  = 'id1';
    // set @iparam_identification2  = 'id2';
    // set @iparam_caste_name  = 'caste';
    // set @iparam_religion_name  = 'religion';
    // set @iparam_mother_language_name  = 'language';
    // set @iparam_home_phone  = 8801933343;
    // set @iparam_mobile_phone  = 8801933344;
    // set @iparam_email  = 'test@gmail.com';
    // set @iparam_address1  = 'add1';
    // set @iparam_address2  = 'add2';
    // set @iparam_city_name  = 'city';
    // set @iparam_city_area  = 'city area';
    // set @iparam_postal_code  = '123456';
    // set @iparam_parent_relationship_type_id  = 1;
    // set @iparam_parent_first_name  = 'ffname';
    // set @iparam_parent_last_name  = 'flname';
    // set @iparam_parent_middle_name  = 'fmname';
    // set @iparam_parent_gender  = 'M';
    // set @iparam_parent_designation_name  = 'IT';

    // set @iparam_session_id = 101;
    // set @iparam_user_id = -1;
    // set @iparam_screen_id = 2001;
    // set @iparam_debug_sproc = 1;
    // set @iparam_audit_screen_visit = 1;

    // select @oparam_admission_id, @oparam_err_flag, @oparam_err_step, @oparam_err_msg;



    public function insert($model)
    {
        $procedure = 'sproc_sch_admission_dml_ins';

        $inputParameters = [
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

        $outputParameters = [
            '@oparam_admission_id',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg'
        ];


        $sql = 'call ' . $procedure . '(';
        $sql .= implode(', ', $inputParameters);
        $sql .= ', ';
        $sql .= implode(', ', $outputParameters);
        $sql .= ');';

        $db = DB::connection('secondDB')->getPdo();
        $dbCall = $db->prepare($sql);

        foreach ($inputParameters as $parameter) {
            $property = substr($parameter, 8);
            $dbCall->bindValue($parameter, $model->{$property});
        }

        $dbCall->execute();

        $response = $db
            ->query('SELECT @oparam_admission_id, @oparam_err_flag, @oparam_err_step, @oparam_err_msg')
            ->fetch(\PDO::FETCH_ASSOC);

        if ($response['@oparam_err_flag'] == null) {
            return true;
        }

        $model->errors = $response['@oparam_err_msg'];
        return false;
    }

    // public function update($model)
    // {
    //     $db = DB::connection('secondDB')->getPdo();

    //     $updateCall = $db->prepare('
    //         call sproc_prd_product_dml_upd (
    //             :iparam_product_entity_id,
    //             :iparam_product_name,
    //             :iparam_product_type_entity_id,
    //             :iparam_unit_rate,
    //             :iparam_active,
    //             :iparam_facility_ids,
    //             :iparam_session_id,
    //             :iparam_user_id,
    //             :iparam_screen_id,
    //             :iparam_debug_sproc,
    //             :iparam_audit_screen_visit,
    //             @oparam_err_flag,
    //             @oparam_err_step,
    //             @oparam_err_msg
    //         );
    //     ');

    //     $updateCall->bindValue(':iparam_product_entity_id', $model->product_entity_id);
    //     $updateCall->bindValue(':iparam_product_name', $model->product_name);
    //     $updateCall->bindValue(':iparam_product_type_entity_id', $model->product_type_entity_id);
    //     $updateCall->bindValue(':iparam_unit_rate', floatval($model->unit_rate));
    //     $updateCall->bindValue(':iparam_active', intval($model->active));
    //     $updateCall->bindValue(':iparam_facility_ids', $model->facility_ids);
    //     $updateCall->bindValue(':iparam_session_id', $model->session_id);
    //     $updateCall->bindValue(':iparam_user_id', $model->user_id);
    //     $updateCall->bindValue(':iparam_screen_id', $model->screen_id);
    //     $updateCall->bindValue(':iparam_debug_sproc', $model->debug_sproc);
    //     $updateCall->bindValue(':iparam_audit_screen_visit', $model->audit_screen_visit);

    //     $updateCall->execute();

    //     $response = $db->query('SELECT @oparam_err_flag, @oparam_err_step, @oparam_err_msg')->fetch(\PDO::FETCH_ASSOC);

    //     if ($response['@oparam_err_flag'] == null) {
    //         return true;
    //     }

    //     $model->errors = $response['@oparam_err_msg'];
    //     return false;
    // }

    // public function delete($model)
    // {
    //     $db = DB::connection('secondDB')->getPdo();

    //     $deleteCall = $db->prepare(
    //         'call sproc_prd_product_dml_del(
    //             :iparam_product_entity_id,
    //             :iparam_session_id,
    //             :iparam_user_id,
    //             :iparam_screen_id,
    //             :iparam_debug_sproc,
    //             :iparam_audit_screen_visit,
    //             @oparam_err_flag,
    //             @oparam_err_step,
    //             @oparam_err_msg
    //         );
    //     ');

    //     $deleteCall->execute([
    //         ':iparam_product_entity_id' => $model->product_entity_id,
    //         ':iparam_session_id' => $model->session_id,
    //         ':iparam_user_id' => $model->user_id,
    //         ':iparam_screen_id' => $model->screen_id,
    //         ':iparam_debug_sproc' => $model->debug_sproc,
    //         ':iparam_audit_screen_visit' => $model->audit_screen_visit,
    //     ]);

    //     $response = $db->query('SELECT @oparam_err_flag, @oparam_err_step, @oparam_err_msg')->fetch(\PDO::FETCH_ASSOC);

    //     if ($response['@oparam_err_flag'] == null) {
    //         return true;
    //     }

    //     $model->errors = $response['@oparam_err_msg'];
    //     return false;
    // }
}
