<?php

namespace App\Http\Modules\Accounting\Models;

use App\Http\Models\Model;

class SchedulePaymentV2 extends Model
{
    protected $screenId = '/cabinet/schedule-payment-v2';

    protected $repositoryNamespace = 'App\Http\Modules\Accounting\Repositories\SchedulePaymentV2Repository';
}
