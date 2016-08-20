<?php

namespace App\Http\Modules\dashboard\school\Models;

use App\Http\Models\Model;

class Student extends Model
{
    protected $screenId = '/cabinet/student-dashboard';

    protected $repositoryNamespace = 'App\Http\Modules\dashboard\school\Repositories\StudentRepository';

    public $info;

    public $receipts;

    public $feeDue;

    public $examPieChart;

    public $exams;

    public $examId;

    public $examName;

    public $exam_grade;

    public $exam_result;

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
        $this->setAttribute('filter_type', 'Student');
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
        $this->exams = $this->repository->getExamWithResult();

        // get selected exam, or first one as default
        if (isset($this->exams[0])) {
            $this->examId = $this->exams[0]['exam_entity_id'];
            $this->examName = $this->exams[0]['exam'];
        }

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
        $this->setAttribute('return_type', 'Student Dashboard');
        $this->setAttribute('filter_entity_id', 0);
        $data = $this->repository->examDetails2($this);
        $examData = first_resultset($data);
        $oparams = second_resultset($data);

        // "class_student_id" => 55
        // "max_total_marks" => "120.00"
        // "student_total_marks" => "98.40"
        // "gpa" => "9.00"
        // "score_percent" => "82.00"
        // "rank" => 3
        $this->exam_grade = isset($oparams[0]['grade']) ? $oparams[0]['grade'] : '';
        $this->exam_result = isset($oparams[0]['pass_fail']) ? $oparams[0]['pass_fail'] : '';

        // map the data for the char.js library
        $this->examPieChart = array_map(function($item) {
            return [
                'value' => $item['subject_percent'],
                'label' => $item['subject'],
            ];
        }, $examData);
    }

    public function loadData()
    {
        $this->loadStudentInfo();
        $this->loadAccountSummary();
        $this->loadExamData();
    }

    public function overallDetails()
    {
        $data = $this->repository->overallDetails($this);
        return first_resultset($data);
    }

    public function feeDueDetails()
    {
        $this->setAttribute('filter_type', 'Student');
        $this->setAttribute('subject_entity_id', $this->student_entity_id);
        $this->setAttribute('return_type', 'Detail');
        $data = $this->repository->studentList($this);
        return first_resultset($data);
    }

    public function smsHistory()
    {
        return $this->repository->smsHistory($this);
    }
}
