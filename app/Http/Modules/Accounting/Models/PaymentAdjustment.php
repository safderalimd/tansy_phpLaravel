<?php

namespace App\Http\Modules\Accounting\Models;

use App\Http\Models\Model;

class PaymentAdjustment extends Model
{
    protected $screenId = 2009;

    protected $repositoryNamespace = 'App\Http\Modules\Accounting\Repositories\PaymentAdjustmentRepository';
}
