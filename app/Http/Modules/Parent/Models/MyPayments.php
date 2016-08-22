<?php

namespace App\Http\Modules\Parent\Models;

use App\Http\Models\Model;

class MyPayments extends Model
{
    protected $screenId = '/cabinet/my-payments';

    protected $repositoryNamespace = 'App\Http\Modules\Parent\Repositories\MyPaymentsRepository';

    public function grid()
    {
        $this->setAttribute('page_number', 1);
        return $this->repository->grid($this);
    }
}
