<?php

namespace App\Http\Modules\Parent\Models;

use App\Http\Models\Model;
use App\Http\Modules\Parent\Models\LazyLoading;

class MyAttendance extends Model
{
    use LazyLoading;

    protected $screenId = '/cabinet/my-attendance';

    protected $repositoryNamespace = 'App\Http\Modules\Parent\Repositories\MyAttendanceRepository';
}
