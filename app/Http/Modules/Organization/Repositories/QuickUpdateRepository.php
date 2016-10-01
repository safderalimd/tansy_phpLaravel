<?php

namespace App\Http\Modules\Organization\Repositories;

use App\Http\Repositories\Repository;

class QuickUpdateRepository extends Repository
{
    public function dropdownOptions($sql)
    {
        if (empty($sql)) {
            return [];
        }

        $options = [];
        foreach ($this->select($sql) as $row) {
            $option = [];
            foreach ($row as $key => $value) {
                if (is_numeric($key)) {
                    continue;
                }
                if (strpos($key, '_id') !== false) {
                    $option['id'] = $value;
                } else {
                    $option['name'] = $value;
                }
            }
            $options[] = $option;
        }

        return $options;
    }

    public function getOrganizationFields()
    {
        // field_id, entity_type, ui_label, data_type, drop_down_sql, field_name
        return $this->lookup('sproc_sys_lkp_field');
    }

    public function getStudentFilter()
    {
        // entity_id, drop_down_list_name
        return $this->lookup('sproc_sch_lkp_student_filter');
    }

    public function grid($model)
    {
        $procedure = 'sproc_org_account_multiple_update_grid';

        $iparams = [
            ':iparam_field_id',
            ':iparam_student_filter_entity_id',
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

    public function update($model)
    {
        $procedure = 'sproc_org_account_multiple_update_dml';

        $iparams = [
            ':iparam_field_id',
            '-iparam_accountEntityID_value',
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

