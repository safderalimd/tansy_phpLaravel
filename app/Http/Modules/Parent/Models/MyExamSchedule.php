<?php

namespace App\Http\Modules\Parent\Models;

use App\Http\Models\Model;

class MyExamSchedule extends Model
{
    protected $screenId = '/cabinet/my-exam-schedule';

    protected $repositoryNamespace = 'App\Http\Modules\Parent\Repositories\MyExamScheduleRepository';

    public function grid()
    {
        $this->setAttribute('page_number', 1);
        return $this->repository->grid($this);
    }
}
