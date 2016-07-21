<?php

namespace App\Http\Modules\Accounting\Models;

use App\Http\Models\Model;

class DailyExpense extends Model
{
    protected $screenId = '/cabinet/daily-expense';

    protected $repositoryNamespace = 'App\Http\Modules\Accounting\Repositories\DailyExpenseRepository';

    protected $selects = [
        'product_type_entity_id',
        'facility_ids',
    ];

}
