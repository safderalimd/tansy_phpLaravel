<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;

class ClassSubjectMap extends Model
{
    protected $screenId = 3002;

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\ClassSubjectMapRepository';

    public function map()
    {
        $this->setAttribute('mapping_flag', 1);
        return $this->repository->mapOrDelete($this);
    }

    public function delete()
    {
        $this->setAttribute('mapping_flag', 0);
        return $this->repository->mapOrDelete($this);
    }
}
