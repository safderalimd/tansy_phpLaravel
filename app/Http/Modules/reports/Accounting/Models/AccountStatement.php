<?php

namespace App\Http\Modules\reports\Accounting\Models;

use App\Http\Models\Model;
use App\Http\Models\Traits\OwnerOrganization;

class AccountStatement extends Model
{
    protected $screenId = '/cabinet/pdf---account-statement';

    public $reportName = 'Account Statement';

    use OwnerOrganization;

    public $schoolName = '-';

    public $schoolWorkPhone = '-';

    public $pdfData;

    protected $repositoryNamespace = 'App\Http\Modules\reports\Accounting\Repositories\AccountStatementRepository';

    public function setSiAttribute($value)
    {
        $this->setAttribute('student_entity_id', $value);
        return $value;
    }

    public function loadPdfData()
    {
        $this->studentData = $this->repository->getStudentById($this->student_entity_id);
        if (isset($this->studentData[0])) {
            $this->studentData = $this->studentData[0];
        }

        $this->pdfData = $this->repository->getReceiptHeaderByStudent($this->student_entity_id);

        $this->setOwnerOrganizationInfo();
    }
}
