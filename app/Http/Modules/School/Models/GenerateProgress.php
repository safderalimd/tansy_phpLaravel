<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;

class GenerateProgress extends Model
{
    protected $screenId = 3010;

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\GenerateProgressRepository';

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
        if (is_null($this->eid)) {
            return [];
        }

        return $this->repository->generateFilteredProgressGrid($this->eid);
    }
}
