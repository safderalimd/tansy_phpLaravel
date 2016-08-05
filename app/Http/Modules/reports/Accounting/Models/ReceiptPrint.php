<?php

namespace App\Http\Modules\reports\Accounting\Models;

use App\Http\Models\Model;

class ReceiptPrint extends Model
{
    protected $screenId = '/cabinet/receipts-listing';

    protected $repositoryNamespace = 'App\Http\Modules\reports\Accounting\Repositories\ReceiptPrintRepository';

    public function receiptGrid()
    {
        return $this->repository->getReceiptGrid($this->account_entity_id);
    }
}
