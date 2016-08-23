<?php

namespace App\Http\Modules\Parent\Models;

use App\Http\Models\Model;
use App\Http\Modules\Parent\Models\LazyLoading;

class MyExamSchedule extends Model
{
    use LazyLoading;

    protected $screenId = '/cabinet/my-exam-schedule';

    protected $repositoryNamespace = 'App\Http\Modules\Parent\Repositories\MyExamScheduleRepository';
}
