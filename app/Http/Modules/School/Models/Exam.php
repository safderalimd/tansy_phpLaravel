<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;
use Session;

class Exam extends Model
{
    protected $screenId = '/cabinet/exam';

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\ExamRepository';

    protected $selects = [
        'exam_type_id',
        'facility_ids',
        'grade_system_id',
        'student_report_version',
    ];

    public $selectedFacilities;

    public function studentReport()
    {
        return $this->repository->studentReport($this);
    }

    public function gradingSystem()
    {
        return $this->repository->gradingSystem($this);
    }

    public function examGrid()
    {
        $data = $this->repository->getExamGrid($this);
        return first_resultset($data);
    }

    public function setDetail($id)
    {
        $this->setAttribute('exam_entity_id', $id);
        $data = $this->repository->detail($this);
        if (isset($data[0])) {
            $data = $data[0];
        }
        $data['exam_name'] = isset($data['exam']) ? $data['exam'] : '';
        $items = array_merge($this->attributes, $data);
        Session::flashInput($items);
        $this->isNewRecord = false;
    }

    public function setActiveAttribute($value)
    {
        $value = (string)$value;
        if (!empty($value) || $value == 'on') {
            return 1;
        }

        return 0;
    }

    public function loadData()
    {
        $facilities = $this->repository->getSelectedFacilities($this->exam_entity_id);
        $this->selectedFacilities = array_column($facilities, 'facility_entity_id');
        if (!is_array($this->selectedFacilities)) {
            $this->selectedFacilities = [];
        }
    }

    public function setCheckboxes()
    {
        $checkboxes = ['attendance_jan', 'attendance_feb', 'attendance_mar', 'attendance_apr', 'attendance_may', 'attendance_jun', 'attendance_jul', 'attendance_aug', 'attendance_sep', 'attendance_oct', 'attendance_nov', 'attendance_dec'];

        foreach ($checkboxes as $checkbox) {
            if (isset($this->{$checkbox})) {
                $this->setAttribute($checkbox, 1);
            } else {
                $this->setAttribute($checkbox, 0);
            }
        }
    }
}
