<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;
use Session;

class Admission extends Model
{
    protected $screenId = '/cabinet/admission';

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\AdmissionRepository';

    protected $customFields;

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

    public function loadDetail()
    {
        $data = $this->repository->detail($this);

        // load the edit form details
        $attributes = first_resultset($data);
        if (isset($attributes[0])) {
            $attributes = $attributes[0];
        }

        foreach ((array) $attributes as $key => $value) {
            if (!is_numeric($key)) {
                $this->setAttribute($key, $value);
            }
        }

        $this->customFields = second_resultset($data);

        foreach ((array) $this->customFields as $field) {
            if (isset($field['column_value']) && isset($field['db_column_name'])) {
                $this->setAttribute($field['db_column_name'], $field['column_value']);
            }
        }

        // flash data to the session to populate edit forms
        Session::flashInput($attributes);

        // mark this model as not a new record
        $this->isNewRecord = false;
    }

    public function customFields()
    {
        return $this->customFields;
    }

    public function getDropdownValues($sql)
    {
        return $this->repository->getDropdownValues($sql);
    }
}
