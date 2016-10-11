<?php

namespace App\Http\Modules\System\Repositories;

use App\Http\Repositories\Repository;
use App\Http\Models\Model;

class CustomFieldsRepository extends Repository
{
    public function getEntities()
    {
        return $this->lookup('sproc_sys_lkp_custom_screen');
    }

    public function getExistingDropDown()
    {
        return $this->lookup('sproc_sys_lkp_custom_field_link_existing_drop_down');
    }

    public function getFieldDataType()
    {
        return $this->lookup('sproc_sys_lkp_custom_field_data_type');
    }

    public function getFieldInputType()
    {
        return $this->lookup('sproc_sys_lkp_custom_field_input_type');
    }

    public function getGrid($id)
    {
        $model = new Model;
        $model->setAttribute('screen_id', $id);

        $procedure = 'sproc_sys_custom_fields_grid';

        $iparams = [
            ':iparam_screen_id',
        ];

        $oparams = [];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }

    public function detail($model, $id)
    {
        $model->setAttribute('custom_field_id', $id);

        $procedure = 'sproc_sys_custom_fields_detail';

        $iparams = [
            ':iparam_custom_field_id',
        ];

        $oparams = [];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);

        if (!isset($data[0][0])) {
            $data = [[]];
        }
        $data[0][0]['order_sequence'] = $data[0][0]['column_sequence'] ?? '';
        $data[0][0]['custom_field_list'] = $data[0][0]['drop_down_list'] ?? '';
        $data[0][0]['existing'] = $data[0][0]['existing_drop_down_selected'] ?? '';
        $data[0][0]['primary_key_id'] = $data[0][0]['drop_down_primary_key_id'] ?? '';
        return $data;
    }

    public function update($model)
    {
        $procedure = 'sproc_sys_custom_fields_dml_upd';

        $iparams = [
            ':iparam_custom_field_id',
            '-iparam_ui_label',
            ':iparam_input_length',
            ':iparam_input_type_id',
            ':iparam_data_type_id',
            ':iparam_order_sequence',
            ':iparam_visible_in_grid',
            ':iparam_mandatory_input',
            ':iparam_active',
            ':iparam_map_to_existing_lookup_id',
            ':iparam_map_to_existing_custom_lookup_id',
            '-iparam_custom_field_list',
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

    public function insert($model)
    {
        $procedure = 'sproc_sys_custom_fields_dml_ins';

        $iparams = [
            ':iparam_custom_field_screen_id',
            '-iparam_ui_label',
            ':iparam_input_length',
            ':iparam_input_type_id',
            ':iparam_data_type_id',
            ':iparam_order_sequence',
            ':iparam_visible_in_grid',
            ':iparam_mandatory_input',
            ':iparam_active',
            ':iparam_map_to_existing_lookup_id',
            ':iparam_map_to_existing_custom_lookup_id',
            '-iparam_custom_field_list',
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
