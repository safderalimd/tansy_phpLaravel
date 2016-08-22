<?php

namespace App\Http\Modules\Parent\Models;

use App\Http\Models\Model;

class MyStudentDiary extends Model
{
    protected $screenId = '/cabinet/my-student-diary';

    protected $repositoryNamespace = 'App\Http\Modules\Parent\Repositories\MyStudentDiaryRepository';

    public function grid()
    {
        $this->setAttribute('page_number', 1);
        return $this->repository->grid($this);
    }
}
