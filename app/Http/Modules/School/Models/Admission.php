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

    public function setAdmittedToClassGroupEntityIdAttribute($value)
    {
        if (!is_numeric($value)) {
            return null;
        }
        return $value;
    }

    public function setStudentGenderAttribute($value)
    {
        return $this->getGenderSymbol($value);
    }

    public function setParentGenderAttribute($value)
    {
        return $this->getGenderSymbol($value);
    }

    public function getGenderSymbol($value)
    {
        $value = strtolower($value);
        $value = trim($value);
        if ($value == 'male') {
            return 'M';
        }
        if ($value == 'female') {
            return 'F';
        }
        return strtoupper($value);
    }
}
