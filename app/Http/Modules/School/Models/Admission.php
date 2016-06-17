<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;

class Admission extends Model
{
    protected $screenId = 3004;

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\AdmissionRepository';

    protected $selects = [
        'facility_entity_id',
        'city_name',
        'admitted_to_class_group_entity_id',
        'caste_name',
        'religion_name',
        'mother_language_name',
        'parent_relationship_type',
        'parent_designation_name',

        'move_to_fiscal_year_entity_id',
        'move_to_class_entity_id',
    ];

    public function moveStudents()
    {
        return $this->repository->moveStudents($this);
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
