<?php

namespace App\Http\Modules\Product\Repositories;

use App\Http\Repositories\Repository;
use App\Http\Models\Model;

class ProductRepository extends Repository
{
    public function getProductGrid()
    {
        $procedure = 'sproc_prd_product_detail';

        $iparams = [
            ':iparam_product_entity_id',
        ];

        $data = $this->procedure(new Model, $procedure, $iparams, []);
        return first_resultset($data);
    }

    public function getModelById($id)
    {
        $procedure = 'sproc_prd_product_detail';

        $iparams = [
            ':iparam_product_entity_id',
        ];

        $model = new Model;
        $model->setAttribute('product_entity_id', $id);

        $data = $this->procedure($model, $procedure, $iparams, []);
        $data = first_resultset($data);
        if (isset($data[0])) {
            $data = $data[0];
        } else {
            $data = [];
        }

        $return = [];
        foreach ($data as $key => $value) {
            if (!is_numeric($key)) {
                $return[$key] = $value;
            }
        }

        return [$return];
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
