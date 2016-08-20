<?php

namespace App\Http\Modules\reports\School\Models;

use App\Http\Models\Model;

class ProgressPrintClass extends Model
{
    protected $screenId = '/cabinet/pdf---class-progress';

    protected $repositoryNamespace = 'App\Http\Modules\reports\School\Repositories\ProgressPrintClassRepository';

    // public $reportName = 'Progress Report';

    // public $schoolName = '-';

    // public $schoolWorkPhone = '-';

    // public $examInfo = [
    //     'exam_start_date' => '-',
    //     'exam_end_date'   => '-',
    //     'class_name'      => '-',
    //     'exam'            => '-',
    //     'max_marks'       => '-',
    // ];

    // public $studentRows = [];

    // public $examName = '-';

    // public $subjectList = [];

    public function getPdfData()
    {
        $data = $this->repository->getProgressList($this);
        return new SchoolProgress($data);
    }

    // public function loadPdfData()
    // {
    //     $data = $this->repository->getProgressList($this);
    //     $this->studentRows = first_resultset($data);
    //     $examInfo = second_resultset($data);
    //     if (isset($examInfo[0])) {
    //         $this->examInfo = $examInfo[0];
    //     }

    //     $this->setSubjectList();
    //     $this->setSchoolNameAndPhone();
    // }

    // public function setSubjectList()
    // {
    //     $subjects = [];

    //     foreach ($this->studentRows as $row) {
    //         $rowSubjects = $this->extractSubjects($row);
    //         $subjects = array_merge($subjects, $rowSubjects);
    //     }

    //     $this->subjectList = array_keys($subjects);
    // }

    // public function setSchoolNameAndPhone()
    // {
    //     $name = $this->repository->getSchoolName();
    //     if (isset($name[0]) && isset($name[0]['organization_name'])) {
    //         $this->schoolName = $name[0]['organization_name'];
    //     }
    //     if (isset($name[0]) && isset($name[0]['work_phone'])) {
    //         $this->schoolWorkPhone = $name[0]['work_phone'];
    //     }
    // }

    // public function extractSubjects($data)
    // {
    //     // remove all numeric keys
    //     foreach ($data as $key => $value) {
    //         if (is_int($key)) {
    //             unset($data[$key]);
    //         }
    //     }

    //     // remove other known keys
    //     unset($data['student_roll_number']);
    //     unset($data['student_full_name']);
    //     unset($data['max_total_marks']);
    //     unset($data['student_total_marks']);
    //     unset($data['score_percent']);
    //     unset($data['grade']);
    //     unset($data['class_student_id']);
    //     unset($data['pass_fail']);
    //     unset($data['class_name']);
    //     unset($data['class_entity_id']);

    //     return $data;
    // }
}
