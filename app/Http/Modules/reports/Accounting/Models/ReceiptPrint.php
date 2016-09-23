<?php

namespace App\Http\Modules\reports\Accounting\Models;

use App\Http\Models\Model;

class ReceiptPrint extends Model
{
    protected $screenId = '/cabinet/receipts-listing';

    protected $repositoryNamespace = 'App\Http\Modules\reports\Accounting\Repositories\ReceiptPrintRepository';

    public function receiptGrid()
    {
        $data = $this->repository->receiptsGrid($this);
        return first_resultset($data);
    }

    public function version()
    {
        return $this->receipt_version;
    }
}
