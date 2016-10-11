<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;
use App\Http\Models\Traits\OwnerOrganization;

class MarkSheet extends Model
{
    protected $screenId = '/cabinet/mark-sheet';

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\MarkSheetRepository';

    use OwnerOrganization;

    public $reportName = 'Mark Sheet Detail';

    public $schoolName = '-';

    public $schoolWorkPhone = '-';

    public function saveMarksheet()
    {
        return $this->repository->save($this);
    }

    public function getMarkSheetDetail()
    {
        return $this->repository->getMarkSheetEditForm($this);
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
