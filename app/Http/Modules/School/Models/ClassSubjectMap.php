<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;

class ClassSubjectMap extends Model
{
    protected $screenId = 3002;

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\ClassSubjectMapRepository';

    public function map()
    {
        return $this->repository->map($this);
    }
}
