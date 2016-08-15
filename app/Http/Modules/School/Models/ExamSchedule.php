<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;

class ExamSchedule extends Model
{
    protected $screenId = '/cabinet/exam-schedule';

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\ExamScheduleRepository';

    public function getExamGrid()
    {
        if (is_null($this->eid)) {
            return [];
        }

        return $this->repository->getExamGrid($this->eid);
    }

    public function examDropdown()
    {
        return $this->repository->examDropdown($this);
    }

    public function scheduleRows()
    {
        return $this->repository->scheduleRows($this);
    }

    public function mapSubjects()
    {
        return $this->repository->mapSubjects($this);
    }

    public function setHiddenClassSubjectIdsAttribute($value)
    {
        $this->setAttribute('class_subject_ids', $value);
        return $value;
    }

    public function setHiddenExamEntityIdAttribute($value)
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

    public function setEidAttribute($value)
    {
        $this->setAttribute('exam_entity_id', $value);
        return $value;
    }
}
