<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;
use Session;

class ExamSchedule extends Model
{
    protected $screenId = '/cabinet/exam-schedule';

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\ExamScheduleRepository';

    protected $selects = [
        'exam_entity_id',
        'sub_exam_entity_id',
        'class_entity_id',
        'subject_entity_id',
    ];

    public function examDropdown()
    {
        return $this->repository->examDropdown($this);
    }

    public function subExamDropdown()
    {
        return $this->repository->subExamDropdown($this);
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

    public function setEsiAttribute($value)
    {
        $this->setAttribute('exam_schedule_id', $value);
        return $value;
    }

    public function paper2()
    {
        return $this->repository->paper2($this);
    }

    public function setDetail($id)
    {
        $this->setAttribute('exam_schedule_id', $id);
        $data = $this->repository->detail($this);
        if (isset($data[0])) {
            $data = $data[0];
        }
        $items = array_merge($this->attributes, $data);
        Session::flashInput($items);
        $this->isNewRecord = false;
    }
}
