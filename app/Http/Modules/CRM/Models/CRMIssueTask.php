<?php

namespace App\Http\Modules\CRM\Models;

use App\Http\Models\Model;

class CRMIssueTask extends Model
{
    protected $screenId = '/cabinet/crm-issue-task';

    protected $repositoryNamespace = 'App\Http\Modules\CRM\Repositories\CRMIssueTaskRepository';

    protected $selects = [
        // 'project_entity_id',
        // 'issue_type_id',
    ];
}
