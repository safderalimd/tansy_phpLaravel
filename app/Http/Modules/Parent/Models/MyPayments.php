<?php

namespace App\Http\Modules\Parent\Models;

use App\Http\Models\Model;
use App\Http\Modules\Parent\Models\LazyLoading;

class MyPayments extends Model
{
    use LazyLoading;

    protected $screenId = '/cabinet/my-payments';

    protected $repositoryNamespace = 'App\Http\Modules\Parent\Repositories\MyPaymentsRepository';
}
