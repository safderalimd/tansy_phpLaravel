<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;
use Session;

class ProgressGradeSetup extends Model
{
    protected $screenId = '/cabinet/progress-grade-setup';

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\ProgressGradeSetupRepository';

    protected $rows = [];

    protected $showAddButton = true;

    public function setGsiAttribute($value)
    {
        $this->setAttribute('grade_system_id', $value);
        return $value;
    }

    public function gradingSystem()
    {
        return $this->repository->gradingSystem($this);
    }

    public function gradePassFail()
    {
        return $this->repository->gradePassFail($this);
    }

    public function loadData()
    {
        if (is_null($this->grade_system_id)) {
            $this->rows = [];
            $this->showAddButton = false;
            return;
        }

        $this->rows = $this->repository->getGrid($this);
    }

    public function rows()
    {
        return $this->rows;
    }

    public function showAddButton()
    {
        return $this->showAddButton;
    }
}
