<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;

class GenerateProgress extends Model
{
    protected $screenId = 3010;

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\GenerateProgressRepository';

    protected $examId;

    public function setExamId($examId)
    {
        $this->examId = $examId;
    }

    public function setEidAttribute($value)
    {
        $this->setAttribute('exam_entity_id', $value);
        return $value;
    }

    public function setCidAttribute($value)
    {
        $this->setAttribute('class_entity_id', $value);
        return $value;
    }

    public function generate()
    {
        return $this->repository->generateProgress($this);
    }

    public function generateFilteredProgressGrid()
    {
        return $this->repository->generateFilteredProgressGrid($this->examId);
    }
}
