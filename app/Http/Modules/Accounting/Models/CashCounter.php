<?php

namespace App\Http\Modules\Accounting\Models;

use App\Http\Models\Model;

class CashCounter extends Model
{
    protected $screenId = '/cabinet/close-cash-counter';

    protected $repositoryNamespace = 'App\Http\Modules\Accounting\Repositories\CashCounterRepository';

    public function closeCounter()
    {
        $this->setAttribute('dateID_paymentTypeID_balanceAmount_list', $this->collection_ids);
        return $this->repository->closeCounter($this);
    }

    public function setF1Attribute($value)
    {
        $this->setAttribute('accountant_individual_entity_id', $value);
        return $value;
    }
}
