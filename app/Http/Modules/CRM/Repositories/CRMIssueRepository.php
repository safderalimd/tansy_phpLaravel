<?php

namespace App\Http\Modules\CRM\Repositories;

use App\Http\Repositories\Repository;

class CRMIssueRepository extends Repository
{
    public function getProjects()
    {
        // project_name, project_entity_id
        return $this->lookup('sproc_crm_lkp_project');
    }

    public function getIssueTypes()
    {
        // issue_type, issue_type_id
        return $this->lookup('sproc_crm_lkp_issue_type');
    }

    public function getPriorities()
    {
        // issue_priority, issue_priority_id
        return $this->lookup('sproc_crm_lkp_priority');
    }

    public function getIssueStatus()
    {
        // issue_status, issue_status_id
        return $this->lookup('sproc_crm_lkp_issue_status');
    }

    public function detail($model, $id)
    {
        $model->setAttribute('issue_id', $id);

        $procedure = 'sproc_crm_issue_detail';

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

    public function insert($model)
    {
        $procedure = 'sproc_crm_issue_dml_ins';

        $iparams = [
            '-iparam_title',
            ':iparam_project_entity_id',
            ':iparam_issue_type_id',
            ':iparam_issue_priority_id',
            ':iparam_issue_status_id',
            ':iparam_product_entity_id',
            ':iparam_product_release_id',
            ':iparam_subject_entity_id',
            '-iparam_issue_due_date',
            ':iparam_owner_entity_id',
            '-iparam_description',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_issue_id',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function update($model)
    {
        $procedure = 'sproc_crm_issue_dml_upd';

        $iparams = [
            ':iparam_issue_id',
            '-iparam_title',
            ':iparam_project_entity_id',
            ':iparam_issue_type_id',
            ':iparam_issue_priority_id',
            ':iparam_issue_status_id',
            ':iparam_product_entity_id',
            ':iparam_product_release_id',
            ':iparam_subject_entity_id',
            '-iparam_issue_due_date',
            ':iparam_owner_entity_id',
            '-iparam_description',
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

    public function commentInsert($model)
    {
        $procedure = 'sproc_crm_issue_comment_dml_ins';

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
