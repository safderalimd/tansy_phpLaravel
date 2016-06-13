<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;

class MoveStudent extends Model
{
    protected $screenId = 3006;

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\MoveStudentRepository';

    public function move()
    {
        return $this->repository->move($this);
    }
}
