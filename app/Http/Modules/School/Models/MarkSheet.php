<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;

class MarkSheet extends Model
{
    protected $screenId = 3008;

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\MarkSheetRepository';

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

    public function setSidAttribute($value)
    {
        $this->setAttribute('subject_entity_id', $value);
        return $value;
    }

    public function lock()
    {
        return $this->repository->lock($this);
    }

    public function unlock()
    {
        return $this->repository->unlock($this);
    }
}
