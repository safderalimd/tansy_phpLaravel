<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;

class MarkSheet extends Model
{
    protected $screenId = '/cabinet/mark-sheet';

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\MarkSheetRepository';

    public function saveMarksheet()
    {
        return $this->repository->save($this);
    }

    public function getMarkSheetDetail()
    {
        return $this->repository->getMarkSheetEditForm($this);
    }

    public function markSheetGrid()
    {
        if (is_null($this->eid)) {
            return [];
        }

        return $this->repository->markSheetGrid($this->eid);
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

    public function examDropdown()
    {
        return $this->repository->examDropdown($this);
    }

    public function getGrid()
    {
        return $this->repository->getGrid($this);
    }

    public function marksGrid()
    {
        return $this->repository->marksGrid($this);
    }
}
