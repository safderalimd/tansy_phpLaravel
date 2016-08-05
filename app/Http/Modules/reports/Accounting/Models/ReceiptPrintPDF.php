<?php

namespace App\Http\Modules\reports\Accounting\Models;

use App\Http\Models\Model;

class ReceiptPrintPDF extends Model
{
    protected $screenId = '/cabinet/pdf---receipt-v1';

    public $reportName = 'Payment Receipt';

    public $schoolName = '-';

    public $schoolWorkPhone = '-';

    public $header;

    public $details;

    protected $repositoryNamespace = 'App\Http\Modules\reports\Accounting\Repositories\ReceiptPrintRepository';

    public function loadPdfData()
    {
        $this->details = $this->repository->getReceiptDetail($this->report_id);
        $this->header = $this->repository->getReceiptHeader($this->report_id);
        if (count($this->header)) {
            $this->header = $this->header[0];
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
