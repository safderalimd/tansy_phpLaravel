<?php

namespace App\Http\Modules\Accounting\Models;

use App\Http\Models\Model;

class DailyExpense extends Model
{
    protected $screenId = '/cabinet/daily-expense';

    protected $repositoryNamespace = 'App\Http\Modules\Accounting\Repositories\DailyExpenseRepository';

    protected $selects = [
        'expense_type_id',
        'supplier_organization_entity_id',
        'payment_type_id',
    ];

    public function setAmountAttribute($value)
    {
        return intval($value);
    }
}
