<?php

namespace App\Http\Modules\reports\School\Models;

use App\Http\Models\Model;

class ProgressPrintStudent extends Model
{
    protected $screenId = '/cabinet/pdf---student-progress-v1';

    public $reportName = 'Progress Report';

    public $schoolName = '-';

    public $schoolWorkPhone = '-';

    public $studentRows;

    public $examName = '-';

    protected $studentDetails;

    protected $repositoryNamespace = 'App\Http\Modules\reports\School\Repositories\ProgressPrintStudentRepository';

    public function loadPdfData()
    {
        $data = $this->repository->getProgressList($this);
        $this->studentRows = first_resultset($data);

        $this->setStudentDetails();
        $this->setSchoolNameAndPhone();
        $this->setExamName();
    }

    public function setStudentDetails()
    {
        $this->studentDetails = $this->repository->getStudentDetails($this->exam_entity_id, $this->class_entity_id);
    }

    public function studentDetails($studentId)
    {
        return array_filter($this->studentDetails, function($item) use ($studentId) {
            return $item['class_student_id'] == $studentId;
        });
    }

    public function setExamName()
    {
        $exam = $this->repository->getExamName($this->exam_entity_id);
        if (isset($exam[0]) && isset($exam[0]['exam'])) {
            $this->examName = $exam[0]['exam'];
        }
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
}
