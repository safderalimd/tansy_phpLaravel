<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;
use Session;

class ExamSetup extends Model
{
    protected $screenId = '/cabinet/exam-setup';

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\ExamSetupRepository';

    protected $selects = [
        'exam_entity_id',
        'sub_exam_entity_id',
        'class_entity_id',
        'subject_entity_id',
        'grade_system_id',
    ];

    public function setEeiAttribute($value)
    {
        $this->setAttribute('exam_entity_id', $value);
        return $value;
    }

    public function examDropdown()
    {
        return $this->repository->examDropdown($this);
    }

    public function studentReport()
    {
        return $this->repository->studentReport($this);
    }

    public function gradingSystem()
    {
        return $this->repository->gradingSystem($this);
    }

    public function classDropdown()
    {
        return $this->repository->classDropdown($this);
    }

    public function subExamDropdown()
    {
        return $this->repository->subExamDropdown($this);
    }

    public function copy()
    {
        return $this->repository->copy($this);
    }

    public function examSetupGrid()
    {
        if (is_null($this->exam_entity_id)) {
            return [];
        }

        $data = $this->repository->getExamSetupGrid($this);
        return first_resultset($data);
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

    public function setEsiAttribute($value)
    {
        $this->setAttribute('exam_schedule_id', $value);
        return $value;
    }
}
