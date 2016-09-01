<?php

namespace App\Http\Modules\System\Repositories;

use App\Http\Repositories\Repository;

class CustomFieldsRepository extends Repository
{
    public function getEntities()
    {
        return $this->lookup('sproc_sys_lkp_custom_screen');

        // return $this->select(
        //     'SELECT
        //         screen_id,
        //         screen_name
        //      FROM view_sys_lkp_custom_screen
        //      ORDER BY screen_name ASC;'
        // );
    }

    public function getExistingDropDown()
    {
        return $this->lookup('sproc_sys_lkp_custom_field_link_existing_drop_down');

        // return $this->select(
        //     'SELECT
        //         row_type,
        //         primary_key_id,
        //         list_name
        //      FROM view_sys_lkp_custom_field_link_existing_drop_down
        //      ORDER BY list_name ASC;'
        // );
    }

    public function getFieldDataType()
    {
        return $this->lookup('sproc_sys_lkp_custom_field_data_type');

        // return $this->select(
        //     'SELECT
        //         data_type_id,
        //         data_type
        //      FROM view_sys_lkp_custom_field_data_type
        //      ORDER BY data_type ASC;'
        // );
    }

    public function getFieldInputType()
    {
        return $this->lookup('sproc_sys_lkp_custom_field_input_type');

        // return $this->select(
        //     'SELECT
        //         input_type_id,
        //         input_type
        //      FROM view_sys_lkp_custom_field_input_type
        //      ORDER BY input_type ASC;'
        // );
    }

    public function getGrid($id)
    {
        return $this->select(
            'SELECT
                ui_label,
                input_type_id,
                data_type_id,
                input_length,
                column_sequence,
                drop_down_list,
                active,
                mandatory_input,
                visible_in_grid,
                custom_field_id,
                screen_id
             FROM view_sys_custom_fields_grid
             WHERE screen_id = :id
             ORDER BY ui_label ASC;', ['id' => $id]
        );
    }

    public function getModelById($id)
    {
        return $this->select(
            'SELECT
                ui_label,
                input_type_id,
                data_type_id,
                input_length,
                column_sequence AS order_sequence,
                drop_down_list AS custom_field_list,
                active,
                existing_drop_down_selected AS existing,
                mandatory_input,
                visible_in_grid,
                custom_field_id,
                screen_id,
                drop_down_primary_key_id AS primary_key_id
             FROM view_sys_custom_fields_grid
             WHERE custom_field_id = :id;', ['id' => $id]
        );
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
