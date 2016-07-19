<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Repository;

class GridRepository extends Repository
{
    public function grid($model)
    {
        $procedure = 'sproc_sys_dynamic_grid';

        $iparams = [
            '-iparam_data_type_filter1',
            '-iparam_db_column_filter1',
            '-iparam_input_value_filter1',
            '-iparam_sql_operator_filter1',
            '-iparam_drop_down_pk_filter1',
            '-iparam_drop_down_parent_filter1',

            '-iparam_data_type_filter2',
            '-iparam_db_column_filter2',
            '-iparam_input_value_filter2',
            '-iparam_sql_operator_filter2',
            '-iparam_drop_down_pk_filter2',
            '-iparam_drop_down_parent_filter2',

            '-iparam_data_type_filter3',
            '-iparam_db_column_filter3',
            '-iparam_input_value_filter3',
            '-iparam_sql_operator_filter3',
            '-iparam_drop_down_pk_filter3',
            '-iparam_drop_down_parent_filter3',

            '-iparam_data_type_filter4',
            '-iparam_db_column_filter4',
            '-iparam_input_value_filter4',
            '-iparam_sql_operator_filter4',
            '-iparam_drop_down_pk_filter4',
            '-iparam_drop_down_parent_filter4',

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

    public function gridFilters($model)
    {
        $procedure = 'sproc_sys_dynamic_grid_filters';

        $iparams = [
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
