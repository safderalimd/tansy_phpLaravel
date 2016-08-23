<?php

namespace App\Http\Modules\Parent\Models;

use App\Http\Models\Model;
use App\Http\Modules\Parent\Models\LazyLoading;

class MyStudentDiary extends Model
{
    use LazyLoading;

    protected $screenId = '/cabinet/my-student-diary';

    protected $repositoryNamespace = 'App\Http\Modules\Parent\Repositories\MyStudentDiaryRepository';
}
