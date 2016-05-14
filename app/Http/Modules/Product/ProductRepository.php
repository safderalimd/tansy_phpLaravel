<?php

namespace App\Http\Modules\Product;

use App\Http\Modules\Product\Models\Product;
use DB;

class ProductRepository
{
    public function getAllProducts() {
        return DB::connection('secondDB')->select(
            'SELECT product, product_type, unit_rate, product_type_entity_id, product_entity_id, active
             FROM view_prd_lkp_product
             ORDER BY product DESC;'
        );
    }

    public function getProductTypes()
    {
        return DB::connection('secondDB')->select(
            'SELECT product_type_entity_id, product_type
             FROM view_prd_lkp_product_type
             ORDER BY product_type;'
        );
    }

    public function getProductFacilities()
    {
        return DB::connection('secondDB')->select(
            'SELECT facility_entity_id, facility_name
             FROM view_org_lkp_facility
             ORDER BY facility_name;'
        );
    }

    public function getProductById($id)
    {
        return DB::connection('secondDB')->select(
            'SELECT product AS product_name, product_type, unit_rate, product_type_entity_id, product_entity_id, active
             FROM view_prd_lkp_product
             WHERE product_entity_id = :productEntityId
             LIMIT 1;', ['productEntityId' => $id]
        );
    }

    public function insert($model)
    {
        $db = DB::connection('secondDB')->getPdo();

        $insertCall = $db->prepare('
            call sproc_prd_product_dml_ins (
                :iparam_product_name,
                :iparam_product_type_entity_id,
                :iparam_unit_rate,
                :iparam_facility_ids,
                :iparam_session_id,
                :iparam_user_id,
                :iparam_screen_id,
                :iparam_debug_sproc,
                :iparam_audit_screen_visit,
                @oparam_product_entity_id,
                @oparam_err_flag,
                @oparam_err_step,
                @oparam_err_msg
            );
        ');

        $insertCall->bindValue(':iparam_product_name', $model->product_name);
        $insertCall->bindValue(':iparam_product_type_entity_id', $model->product_type_entity_id);
        $insertCall->bindValue(':iparam_unit_rate', $model->unit_rate);
        $insertCall->bindValue(':iparam_facility_ids', $model->facility_ids);
        $insertCall->bindValue(':iparam_session_id', $model->session_id);
        $insertCall->bindValue(':iparam_user_id', $model->user_id);
        $insertCall->bindValue(':iparam_screen_id', $model->screen_id);
        $insertCall->bindValue(':iparam_debug_sproc', $model->debug_sproc);
        $insertCall->bindValue(':iparam_audit_screen_visit', $model->audit_screen_visit);

        $insertCall->execute();

        $response = $db
            ->query('SELECT @oparam_product_entity_id, @oparam_err_flag, @oparam_err_step, @oparam_err_msg')
            ->fetch(\PDO::FETCH_ASSOC);

        if ($response['@oparam_err_flag'] == null) {
            $model->productEntityId = $response['@oparam_product_entity_id'];
            return true;
        }

        $model->errors = $response['@oparam_err_msg'];
        return false;
    }

    public function update($model)
    {
        $db = DB::connection('secondDB')->getPdo();

        $updateCall = $db->prepare('
            call sproc_prd_product_dml_upd (
                :iparam_product_entity_id,
                :iparam_product_name,
                :iparam_product_type_entity_id,
                :iparam_unit_rate,
                :iparam_active,
                :iparam_facility_ids,
                :iparam_session_id,
                :iparam_user_id,
                :iparam_screen_id,
                :iparam_debug_sproc,
                :iparam_audit_screen_visit,
                @oparam_err_flag,
                @oparam_err_step,
                @oparam_err_msg
            );
        ');

        $updateCall->bindValue(':iparam_product_entity_id', $model->product_entity_id);
        $updateCall->bindValue(':iparam_product_name', $model->product_name);
        $updateCall->bindValue(':iparam_product_type_entity_id', $model->product_type_entity_id);
        $updateCall->bindValue(':iparam_unit_rate', floatval($model->unit_rate));
        $updateCall->bindValue(':iparam_active', intval($model->active));
        $updateCall->bindValue(':iparam_facility_ids', $model->facility_ids);
        $updateCall->bindValue(':iparam_session_id', $model->session_id);
        $updateCall->bindValue(':iparam_user_id', $model->user_id);
        $updateCall->bindValue(':iparam_screen_id', $model->screen_id);
        $updateCall->bindValue(':iparam_debug_sproc', $model->debug_sproc);
        $updateCall->bindValue(':iparam_audit_screen_visit', $model->audit_screen_visit);

        $updateCall->execute();

        $response = $db->query('SELECT @oparam_err_flag, @oparam_err_step, @oparam_err_msg')->fetch(\PDO::FETCH_ASSOC);

        if ($response['@oparam_err_flag'] == null) {
            return true;
        }

        $model->errors = $response['@oparam_err_msg'];
        return false;
    }

    public function delete($model)
    {
        $db = DB::connection('secondDB')->getPdo();

        $deleteCall = $db->prepare(
            'call sproc_prd_product_dml_del(
                :iparam_product_entity_id,
                :iparam_session_id,
                :iparam_user_id,
                :iparam_screen_id,
                :iparam_debug_sproc,
                :iparam_audit_screen_visit,
                @oparam_err_flag,
                @oparam_err_step,
                @oparam_err_msg
            );
        ');

        $deleteCall->execute([
            ':iparam_product_entity_id' => $model->product_entity_id,
            ':iparam_session_id' => $model->session_id,
            ':iparam_user_id' => $model->user_id,
            ':iparam_screen_id' => $model->screen_id,
            ':iparam_debug_sproc' => $model->debug_sproc,
            ':iparam_audit_screen_visit' => $model->audit_screen_visit,
        ]);

        $response = $db->query('SELECT @oparam_err_flag, @oparam_err_step, @oparam_err_msg')->fetch(\PDO::FETCH_ASSOC);

        if ($response['@oparam_err_flag'] == null) {
            return true;
        }

        $model->errors = $response['@oparam_err_msg'];
        return false;
    }
}
