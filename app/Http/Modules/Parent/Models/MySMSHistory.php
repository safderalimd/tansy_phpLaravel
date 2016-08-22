<?php

namespace App\Http\Modules\Parent\Models;

use App\Http\Models\Model;

class MySMSHistory extends Model
{
    protected $screenId = '/cabinet/my-sms-history';

    protected $repositoryNamespace = 'App\Http\Modules\Parent\Repositories\MySMSHistoryRepository';

    public function grid()
    {
        $this->setAttribute('page_number', 1);
        return $this->repository->grid($this);
    }
}
