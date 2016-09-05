<?php

namespace App\Http\Modules\reports\School\Models;

use App\Http\Models\Model;

class StudentDetail extends Model
{
    protected $screenId = '/cabinet/pdf---student-detail';

    public $pdfData = [];

    protected $repositoryNamespace = 'App\Http\Modules\reports\School\Repositories\StudentDetailRepository';

    public $reportName = 'Student Personal Detail Form';

    public $schoolName = '-';

    public $schoolWorkPhone = '-';

    public function setSiAttribute($value)
    {
        $this->setAttribute('student_entity_id', $value);
        return $value;
    }

    public function loadPdfData()
    {
        $this->pdfData = $this->repository->getPdfData($this->student_entity_id);
        if (isset($this->pdfData[0])) {
            $this->pdfData = $this->pdfData[0];
        }

        $this->setSchoolNameAndPhone();
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
