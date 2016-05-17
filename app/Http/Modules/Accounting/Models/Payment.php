<?php

namespace App\Http\Modules\Accounting\Models;

use App\Http\Models\Model;

class Payment extends Model
{
    protected $screenId = 2010;

    protected $repositoryNamespace = 'App\Http\Modules\Accounting\Repositories\PaymentRepository';

    public function getAllPayments()
    {
        return $this->repository->getAllPayments($this);
    }
}
