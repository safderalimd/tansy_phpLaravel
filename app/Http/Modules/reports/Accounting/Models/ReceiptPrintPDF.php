<?php

namespace App\Http\Modules\reports\Accounting\Models;

use App\Http\Models\Model;
use App\Http\Models\Traits\OwnerOrganization;

class ReceiptPrintPDF extends Model
{
    protected $screenId = '/cabinet/pdf---receipt-v1';

    public $reportName = 'Payment Receipt';

    use OwnerOrganization;

    public $schoolName = '-';

    public $schoolWorkPhone = '-';

    public $header;

    public $details;

    protected $repositoryNamespace = 'App\Http\Modules\reports\Accounting\Repositories\ReceiptPrintRepository';

    public function setIdAttribute($value)
    {
        $this->setAttribute('receipt_id', $value);
        return $value;
    }

    public function loadPdfDataV1()
    {
        $this->details = $this->repository->getReceiptDetail($this->receipt_id);
        $this->header = $this->repository->getReceiptHeader($this->receipt_id);
        if (count($this->header)) {
            $this->header = $this->header[0];
        }

        $this->setOwnerOrganizationInfo();
    }

    public function getPdfDataV2()
    {
        return $this->repository->receipt($this);
    }
}
