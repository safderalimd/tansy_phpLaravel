<?php

namespace App\Http\Modules\CRM\Repositories;

use App\Http\Repositories\Repository;

class CRMIssueTaskRepository extends Repository
{
    public function getIssueTaskTypes()
    {
        // task_type, task_type_id
        return $this->lookup('sproc_crm_lkp_issue_task_type');
    }

    public function getProductComponent($model)
    {
        // component_name, product_component_id, product_entity_id
        $procedure = 'sproc_prd_lkp_product_component';

        $iparams = [':iparam_null_iparam'];

        $data = $this->procedure($model, $procedure, $iparams, []);
        return first_resultset($data);
    }

    public function detail($model, $id)
    {
        $model->setAttribute('task_id', $id);

        $procedure = 'sproc_crm_issue_task_detail';

        $iparams = [
            ':iparam_task_id',
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
        $procedure = 'sproc_crm_issue_task_dml_ins';

        $iparams = [
            ':iparam_issue_id',
            ':iparam_task_type_id',
            ':iparam_product_component_id',
            ':iparam_assigned_individual_entity_id',
            '-iparam_due_date',
            ':iparam_task_status_id',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_task_id',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function update($model)
    {
        $procedure = 'sproc_crm_issue_task_dml_upd';

        $iparams = [
            ':iparam_task_id',
            ':iparam_task_type_id',
            ':iparam_product_component_id',
            ':iparam_assigned_individual_entity_id',
            '-iparam_due_date',
            ':iparam_task_status_id',
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
