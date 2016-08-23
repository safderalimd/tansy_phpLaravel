<?php

namespace App\Http\Modules\Parent\Models;

use App\Http\Models\Model;
use App\Http\Modules\Parent\Models\LazyLoading;

class MyExamSyllabus extends Model
{
    use LazyLoading;

    protected $screenId = '/cabinet/my-exam-syllabus';

    protected $repositoryNamespace = 'App\Http\Modules\Parent\Repositories\MyExamSyllabusRepository';
}
