<?php

namespace App\Http\Modules\reports\School\Models;

use App\Http\Models\Model;
use App\Http\Models\Traits\OwnerOrganization;

class OneStudent extends Model
{
    protected $screenId = '/cabinet/pdf---student';

    protected $repositoryNamespace = 'App\Http\Modules\reports\School\Repositories\OneStudentRepository';

    use OwnerOrganization;

    public $pdfData = [];

    public $reportName = 'Student Personal Detail Form';

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

        $this->setOwnerOrganizationInfo();
    }
}
