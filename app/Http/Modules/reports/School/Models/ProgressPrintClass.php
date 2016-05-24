<?php

namespace App\Http\Modules\reports\School\Models;

use App\Http\Models\Model;

class ProgressPrintClass extends Model
{
    protected $screenId = 3016;

    public $reportName = 'Progress Report - Class';

    public $schoolName = '-';

    public $schoolWorkPhone = '-';

    public $examInfo = [
        'exam_start_date' => '-',
        'exam_end_date'   => '-',
        'class_name'      => '-',
        'exam'            => '-',
    ];

    public $studentRows = [];

    public $examName = '-';

    public $subjectList = [];

    protected $repositoryNamespace = 'App\Http\Modules\reports\School\Repositories\ProgressPrintClassRepository';

    public function progressList()
    {
        return $this->repository->getProgressList($this);
    }

    public function loadPdfData()
    {
        $list = $this->progressList();
        if (count($list)) {
            $this->examInfo = array_pop($list);
            if (!empty($list)) {
                $this->studentRows = $list;
            }
        }

        $this->setSubjectList();
        $this->setSchoolNameAndPhone();
    }

    public function setSubjectList()
    {
        $subjects = [];

        foreach ($this->studentRows as $row) {
            $rowSubjects = $this->extractSubjects($row);
            $subjects = array_merge($subjects, $rowSubjects);
        }

        $this->subjectList = array_keys($subjects);
    }

    public function setSchoolNameAndPhone()
    {
        $name = $this->repository->getSchoolName();
        if (isset($name[0]) && isset($name[0]['organization_name'])) {
            $this->schoolName = $name[0]['organization_name'];
        }
        if (isset($name[0]) && isset($name[0]['work_phone'])) {
            $this->schoolWorkPhone = $name[0]['work_phone'];
        }
    }

    public function extractSubjects($data)
    {
        // remove all numeric keys
        foreach ($data as $key => $value) {
            if (is_int($key)) {
                unset($data[$key]);
            }
        }

        // remove other known keys
        unset($data['student_roll_number']);
        unset($data['student_full_name']);
        unset($data['max_total_marks']);
        unset($data['student_total_marks']);
        unset($data['score_percent']);
        unset($data['grade']);
        unset($data['class_student_id']);
        unset($data['pass_fail']);
        unset($data['class_name']);
        unset($data['class_entity_id']);

        return $data;
    }
}