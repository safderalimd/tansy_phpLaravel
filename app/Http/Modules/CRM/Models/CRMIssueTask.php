<?php

namespace App\Http\Modules\CRM\Models;

use App\Http\Models\Model;

class CRMIssueTask extends Model
{
    protected $screenId = '/cabinet/crm-issue-task';

    protected $repositoryNamespace = 'App\Http\Modules\CRM\Repositories\CRMIssueTaskRepository';

    protected $selects = [
        'task_type_id',
        'product_component_id',
        'assigned_individual_entity_id',
        'task_status_id',
    ];

    public function setIdAttribute($value)
    {
        $this->setAttribute('issue_id', $value);
        return $value;
    }

    public function productComponent()
    {
        return $this->repository->getProductComponent($this);
    }
}
