<?php

namespace App\Http\Modules\Product\Repositories;

use App\Http\Repositories\Repository;
use App\Http\Models\Model;

class ProductRepository extends Repository
{
    public function getModelById($id)
    {
        $procedure = 'sproc_prd_product_detail';

        $iparams = [
            ':iparam_product_entity_id',
        ];

        $model = new Model;
        $model->setAttribute('product_entity_id', $id);

        $data = $this->procedure($model, $procedure, $iparams, []);
        return first_resultset($data);

        // return $this->select(
        //     'SELECT
        //         product AS product_name,
        //         product_type,
        //         unit_rate,
        //         product_type_entity_id,
        //         product_entity_id,
        //         active
        //      FROM view_prd_lkp_product
        //      WHERE product_entity_id = :id
        //      LIMIT 1;', ['id' => $id]
        // );
    }

    public function getSelectedFacilities($id)
    {
        return $this->select(
            'SELECT
                entity_id AS product_entity_id,
                facility_entity_id
             FROM view_org_entity_scope
             WHERE entity_id = :id
             ORDER BY product_entity_id, facility_entity_id;',
            ['id' => $id]
        );
    }

    public function insert($model)
    {
        $procedure = 'sproc_prd_product_dml_ins';

        $iparams = [
            '-iparam_product_name',
            ':iparam_product_type_entity_id',
            ':iparam_unit_rate',
            ':iparam_facility_ids',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_product_entity_id',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function update($model)
    {
        $procedure = 'sproc_prd_product_dml_upd';

        $iparams = [
            ':iparam_product_entity_id',
            '-iparam_product_name',
            ':iparam_product_type_entity_id',
            ':iparam_unit_rate',
            ':iparam_active',
            ':iparam_facility_ids',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function delete($model)
    {
        $procedure = 'sproc_prd_product_dml_del';

        $iparams = [
            ':iparam_product_entity_id',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }
}
