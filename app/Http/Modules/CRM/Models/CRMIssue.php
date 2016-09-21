<?php

namespace App\Http\Modules\CRM\Models;

use App\Http\Models\Model;

class CRMIssue extends Model
{
    protected $screenId = '/cabinet/crm-issue';

    protected $repositoryNamespace = 'App\Http\Modules\CRM\Repositories\CRMIssueRepository';

    public $comments;

    public $tasks;

    protected $selects = [
        'project_entity_id',
        'issue_type_id',
        'issue_priority_id',
        'issue_status_id',
        'product_entity_id',
        'product_release_id',
        'subject_entity_id',
        'owner_entity_id',
    ];

    public static function findIssue($id)
    {
        $issue = new static;
        $data = $issue->repository->detail($issue, $id);
        $issue->setDetailAttributes($issue, first_resultset($data));

        $issue->comments = second_resultset($data);
        $issue->tasks = third_resultset($data);

        return $issue;
    }

    public function saveComment()
    {
        return $this->repository->commentInsert($this);
    }

    public function comments()
    {
        return (array) $this->comments;
    }

    public function tasks()
    {
        return (array) $this->tasks;
    }
}
