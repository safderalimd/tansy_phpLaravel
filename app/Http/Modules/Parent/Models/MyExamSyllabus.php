<?php

namespace App\Http\Modules\Parent\Models;

use App\Http\Models\Model;

class MyExamSyllabus extends Model
{
    protected $screenId = '/cabinet/my-exam-syllabus';

    protected $repositoryNamespace = 'App\Http\Modules\Parent\Repositories\MyExamSyllabusRepository';

    public function grid()
    {
        $this->setAttribute('page_number', 1);
        return $this->repository->grid($this);
    }
}
