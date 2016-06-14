<?php

namespace App\Http\Modules\dashboard\school\Models;

use App\Http\Models\Model;

class Exam extends Model
{
    protected $screenId = 3012;

    protected $repositoryNamespace = 'App\Http\Modules\dashboard\school\Repositories\ExamRepository';

    public $examId;

    public $examDonoughtChart;

    public $subjectPerformanceDetailsChart;

    public $classPerformancePieChart;

    public $classSubjectPerformancePieChart;

    public $clasess;

    public $className;

    public $classId;

    public function examIsSet()
    {
        if (!isset($this->exam_entity_id)) {
            return false;
        }

        if (!is_numeric($this->exam_entity_id)) {
            return false;
        }

        return true;
    }

    public function loadData()
    {
        if (!$this->examIsSet()) {
            return;
        }

        $this->examId = $this->exam_entity_id;

        $examInfo = $this->repository->examInfo($this);

        $this->examDonoughtChart = array_map(function($item) {
            return [
                'value' => $item['subject_percent'],
                'label' => $item['subject'],
            ];
        }, first_resultset($examInfo));

        $this->subjectPerformanceDetailsChart = array_map(function($item) {
            return [
                'value' => $item['student_count'],
                'label' => $item['grade'],
            ];
        }, second_resultset($examInfo));

        $this->setClassFilter();
        $classPerformance = $this->repository->classPerformance($this);
        $this->classPerformancePieChart = array_map(function($item) {
            return [
                'value' => $item['student_count'],
                'label' => $item['grade'],
            ];
        }, first_resultset($classPerformance));

        $this->classSubjectPerformancePieChart = array_map(function($item) {
            return [
                'value' => $item['subject_percent'],
                'label' => $item['subject'],
            ];
        }, second_resultset($classPerformance));
    }

    public function setClassFilter()
    {
        // set first class as default
        $this->classess = $this->repository->getClasses();
        $this->classId = $this->classess[0]['class_entity_id'];
        $this->className = $this->classess[0]['class_name'];

        // if another class is set in the request, use it
        if (isset($this->class_entity_id) && is_numeric($this->class_entity_id)) {
            $this->classId = $this->class_entity_id;
            foreach ($this->classess as $row) {
                if ($row['class_entity_id'] == $this->classId) {
                    $this->className = $row['class_name'];
                    break;
                }
            }
        } else {
            $this->setAttribute('class_entity_id', $this->classId);
        }

        $this->setAttribute('exam_class_id', $this->classId);
    }

    public function topperDetails()
    {
        return first_resultset($this->repository->topperDetails($this));
    }

    public function failedStudents()
    {
        return first_resultset($this->repository->failedStudents($this));
    }

    public function absentees()
    {
        return first_resultset($this->repository->absentees($this));
    }
}
