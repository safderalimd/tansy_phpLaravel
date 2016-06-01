<?php

namespace App\Http\Modules\Accounting\Models;

use App\Http\Models\Model;

class SchedulePayment extends Model
{
    protected $screenId = 2011;

    protected $repositoryNamespace = 'App\Http\Modules\Accounting\Repositories\SchedulePaymentRepository';

    public function setActiveAttribute($value)
    {
        if (!empty($value) || $value == 'on') {
            return 1;
        }

        return 0;
    }
}
