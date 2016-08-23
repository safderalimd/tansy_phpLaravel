<?php

namespace App\Http\Modules\Parent\Models;

use App\Http\Models\Model;
use App\Http\Modules\Parent\Models\LazyLoading;

class MySMSHistory extends Model
{
    use LazyLoading;

    protected $screenId = '/cabinet/my-sms-history';

    protected $repositoryNamespace = 'App\Http\Modules\Parent\Repositories\MySMSHistoryRepository';
}
