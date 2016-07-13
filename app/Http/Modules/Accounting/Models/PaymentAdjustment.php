<?php

namespace App\Http\Modules\Accounting\Models;

use App\Http\Models\Model;

class PaymentAdjustment extends Model
{
    protected $screenId = '/cabinet/payment-adjustment';

    protected $repositoryNamespace = 'App\Http\Modules\Accounting\Repositories\PaymentAdjustmentRepository';

    protected $selects = [
        'payment_type_id',
    ];

    public function getAll()
    {
        return $this->repository->getAll($this);
    }
}
