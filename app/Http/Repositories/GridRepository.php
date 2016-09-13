<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Repository;

class GridRepository extends Repository
{
    public function changeKeys($sql, $keyId, $keyName)
    {
        $rows = $this->select($sql);
        foreach ($rows as $key => $option) {
            if (!is_array($rows[$key])) {
                continue;
            }
            $rows[$key]['drop_down_filter_id'] = isset($option[$keyId]) ? $option[$keyId] : '-';
            $rows[$key]['drop_down_list_name'] = isset($option[$keyName]) ? $option[$keyName] : '-';
        }
        return $rows;
    }

    public function filterDropdownValues($sql)
    {
        if (strpos($sql, 'call sproc_org_lkp_account_type_filter') !== false) {
            return $this->changeKeys($sql, 'entity_id', 'drop_down_list_name');

        } elseif (strpos($sql, 'call sproc_prd_lkp_product') !== false) {
            return $this->changeKeys($sql, 'product_entity_id', 'product_name');

        } elseif (strpos($sql, 'call sproc_sec_lkp_login_users') !== false) {
            return $this->changeKeys($sql, 'individual_entity_id', 'login_name');

        } elseif (strpos($sql, 'call sproc_sch_lkp_main_exam') !== false) {
            return $this->changeKeys($sql, 'exam_entity_id', 'exam');
        }

        return $this->select($sql);
    }

    public function dynamicGrid($params, $model)
    {
        $procedure = $params->procedure();
        $iparams   = $params->iparams();
        $oparams   = $params->oparams();

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
