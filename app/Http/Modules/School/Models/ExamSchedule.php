<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;

class ExamSchedule extends Model
{
    protected $screenId = 3007;

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\ExamScheduleRepository';

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
        return intval($value);
    }

    public function setHiddenExamEntityIdAttribute($value)
    {
        $this->setAttribute('exam_entity_id', $value);
        return $value;
    }
}
