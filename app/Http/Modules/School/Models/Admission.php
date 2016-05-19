<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;

class Admission extends Model
{
    protected $screenId = 3004;

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\AdmissionRepository';

    public function moveStudents()
    {
        return $this->repository->moveStudents($this);
    }

    public function setParentDesignationNameAttribute($value)
    {
        $this->setAttribute('designation_name', $value);
        return $value;
    }
}
