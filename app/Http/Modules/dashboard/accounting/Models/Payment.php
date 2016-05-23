<?php

namespace App\Http\Modules\dashboard\accounting\Models;

use App\Http\Models\Model;

class Payment extends Model
{
    protected $screenId = 2011;

    protected $repositoryNamespace = 'App\Http\Modules\dashboard\accounting\Repositories\PaymentRepository';
}
