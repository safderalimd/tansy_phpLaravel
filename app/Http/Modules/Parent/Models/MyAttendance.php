<?php

namespace App\Http\Modules\Parent\Models;

use App\Http\Models\Model;

class MyAttendance extends Model
{
    protected $screenId = '/cabinet/my-attendance';

    protected $repositoryNamespace = 'App\Http\Modules\Parent\Repositories\MyAttendanceRepository';

    public function grid()
    {
        $this->setAttribute('page_number', 1);
        return $this->repository->grid($this);
    }
}
