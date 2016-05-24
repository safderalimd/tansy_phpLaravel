<?php

namespace App\Http\Modules\dashboard\school\Models;

use App\Http\Models\Model;

class Student extends Model
{
    protected $screenId = 3011;

    protected $repositoryNamespace = 'App\Http\Modules\dashboard\school\Repositories\StudentRepository';

    public $info;

    public $receipts;

    public $feeDue;

    public $examPieChart;

    public $exams;

    public $examId;

    public $examName;

    public function loadStudentInfo()
    {
        $studentInfo = $this->repository->studentInfo($this);

        if (isset($studentInfo[0][0])) {
            $this->info = $studentInfo[0][0];
        }

        if (isset($studentInfo[1])) {
            $this->receipts = $studentInfo[1];
        }
    }

    public function loadAccountSummary()
    {
        $this->setAttribute('filter_type', 'entity');
        $this->setAttribute('subject_entity_id', $this->student_entity_id);
        $this->setAttribute('return_type', 'Summary');
        $data = $this->repository->studentList($this);
        if (isset($data[0][0][2])) {
            $this->feeDue = $data[0][0][2];
        }
    }

    public function loadExamData()
    {
        // load all exams
        $this->exams = $this->repository->getExam();

        // get selected exam, or first one as default
        $this->examId = $this->exams[0]['exam_entity_id'];
        $this->examName = $this->exams[0]['exam'];
        if (isset($this->exam_entity_id) && is_numeric($this->exam_entity_id)) {
            $this->examId = $this->exam_entity_id;
            foreach ($this->exams as $exam) {
                if ($exam['exam_entity_id'] == $this->examId) {
                    $this->examName = $exam['exam'];
                    break;
                }
            }
        } else {
            $this->setAttribute('exam_entity_id', $this->examId);
        }

        // call sproc and get the data
        $examData = $this->repository->examDetails($this);

        // map the data for the char.js library
        $this->examPieChart = array_map(function($item) {
            return [
                'value' => $item['subject_percent'],
                'label' => $item['subject'],
            ];
        }, $examData[0]);
    }

    public function loadData()
    {
        $this->loadStudentInfo();
        $this->loadAccountSummary();
        $this->loadExamData();
    }

    public function overallDetails()
    {
        return $this->repository->overallDetails($this);
    }

    public function feeDueDetails()
    {
        $this->setAttribute('filter_type', 'entity');
        $this->setAttribute('subject_entity_id', $this->student_entity_id);
        $this->setAttribute('return_type', 'Details');
        $data = $this->repository->studentList($this);
        dd($data);
        if (isset($data[0][0][2])) {
            $this->feeDue = $data[0][0][2];
        }
    }

    public function smsHistory()
    {
        $data = $this->repository->smsHistory($this);
        if (isset($data[0])) {
            return $data[0];
        }
        return [];
    }
}
