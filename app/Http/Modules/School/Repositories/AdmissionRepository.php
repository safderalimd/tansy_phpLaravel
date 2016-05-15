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



    // public function insert($model)
    // {
    //     $db = DB::connection('secondDB')->getPdo();

    //     $insertCall = $db->prepare('
    //         call sproc_prd_product_dml_ins (
    //             :iparam_product_name,
    //             :iparam_product_type_entity_id,
    //             :iparam_unit_rate,
    //             :iparam_facility_ids,
    //             :iparam_session_id,
    //             :iparam_user_id,
    //             :iparam_screen_id,
    //             :iparam_debug_sproc,
    //             :iparam_audit_screen_visit,
    //             @oparam_product_entity_id,
    //             @oparam_err_flag,
    //             @oparam_err_step,
    //             @oparam_err_msg
    //         );
    //     ');

    //     $insertCall->bindValue(':iparam_product_name', $model->product_name);
    //     $insertCall->bindValue(':iparam_product_type_entity_id', $model->product_type_entity_id);
    //     $insertCall->bindValue(':iparam_unit_rate', $model->unit_rate);
    //     $insertCall->bindValue(':iparam_facility_ids', $model->facility_ids);
    //     $insertCall->bindValue(':iparam_session_id', $model->session_id);
    //     $insertCall->bindValue(':iparam_user_id', $model->user_id);
    //     $insertCall->bindValue(':iparam_screen_id', $model->screen_id);
    //     $insertCall->bindValue(':iparam_debug_sproc', $model->debug_sproc);
    //     $insertCall->bindValue(':iparam_audit_screen_visit', $model->audit_screen_visit);

    //     $insertCall->execute();

    //     $response = $db
    //         ->query('SELECT @oparam_product_entity_id, @oparam_err_flag, @oparam_err_step, @oparam_err_msg')
    //         ->fetch(\PDO::FETCH_ASSOC);

    //     if ($response['@oparam_err_flag'] == null) {
    //         $model->productEntityId = $response['@oparam_product_entity_id'];
    //         return true;
    //     }

    //     $model->errors = $response['@oparam_err_msg'];
    //     return false;
    // }

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
