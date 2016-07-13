<?php

namespace App\Http\Modules\Accounting\Models;

use App\Http\Models\Model;

class CashCounter extends Model
{
    protected $screenId = '/cabinet/close-cash-counter';

    protected $repositoryNamespace = 'App\Http\Modules\Accounting\Repositories\CashCounterRepository';

    public function closeCounter()
    {
        $this->setAttribute('dateIDs_collections', $this->collection_ids);
        return $this->repository->closeCounter($this);
    }
}
