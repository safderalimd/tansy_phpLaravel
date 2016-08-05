<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;

class ClassSubjectMap extends Model
{
    protected $screenId = '/cabinet/class-subject-map';

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
