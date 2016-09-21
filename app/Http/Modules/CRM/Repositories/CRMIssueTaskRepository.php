<?php

namespace App\Http\Modules\CRM\Repositories;

use App\Http\Repositories\Repository;

class CRMIssueTaskRepository extends Repository
{
    public function detail($model)
    {
        $procedure = 'sproc_crm_issue_task_detail';

        $iparams = [
            ':iparam_issue_id',
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

    public function taskInsert($model)
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

    public function taskUpdate($model)
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
