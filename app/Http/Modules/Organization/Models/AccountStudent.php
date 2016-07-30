<?php

namespace App\Http\Modules\Organization\Models;

use App\Http\Models\Model;
use Session;

class AccountStudent extends Model
{
    protected $screenId = '/cabinet/student-account';

    protected $repositoryNamespace = 'App\Http\Modules\Organization\Repositories\AccountStudentRepository';

    protected $customFields;

    protected $relationshipRows;

    protected $documentRows;

    protected $selects = [
        'facility_entity_id',
        'city_id',
        'city_area',
        'admitted_class_entity_id',
        'caste_id',
        'religion_id',
        'mother_language_id',
        'parent_relationship_type_id',
        'parent_designation_id',
        'document_type_id',
        'security_group_entity_id',
        'view_default_facility_id',
    ];

    public function setActiveToFalse()
    {
        $this->attributes['active'] = 0;
    }

    public function setLoginActiveToFalse()
    {
        $this->attributes['login_active'] = 0;
    }

    public function setActiveAttribute($value)
    {
        $value = (string)$value;
        if (!empty($value) || $value == 'on') {
            return 1;
        }

        return 0;
    }

    public function setLoginActiveAttribute($value)
    {
        $value = (string)$value;
        if (!empty($value) || $value == 'on') {
            return 1;
        }

        return 0;
    }

    public function loadDetail()
    {
        $data = $this->repository->detail($this);

        $flash = [];

        // load the edit form details
        $atr = first_resultset($data);
        if (isset($atr[0])) {
            $atr = $atr[0];
        }

        foreach ((array) $atr as $key => $value) {
            if (!is_numeric($key)) {
                $this->setAttribute($key, $value);
            }
            $flash[$key] = $value;
        }

        $this->customFields = second_resultset($data);

        foreach ((array) $this->customFields as $field) {
            if (isset($field['column_value']) && isset($field['db_column_name'])) {
                $this->setAttribute($field['db_column_name'], $field['column_value']);
            }
        }

        // mark this model as not a new record
        $this->isNewRecord = false;

        $this->relationshipRows = third_resultset($data);
        $relationshipRows = [];
        $i = 1;
        foreach ((array) $this->relationshipRows as $field) {

            if (isset($field['relationship_type_id'])) {
                $relationshipRows['relationship_type_id_' . $i] = $field['relationship_type_id'];
            }
            if (isset($field['parent_name'])) {
                $relationshipRows['parent_name_' . $i] = $field['parent_name'];
            }
            if (isset($field['designation_id'])) {
                $relationshipRows['designation_id_' . $i] = $field['designation_id'];
            }
            if (isset($field['qualification_id'])) {
                $relationshipRows['qualification_id_' . $i] = $field['qualification_id'];
            }

            $i++;
        }

        $this->documentRows = fourth_resultset($data);
        $documentRows = [];
        $i = 1;
        foreach ((array) $this->documentRows as $field) {

            if (isset($field['document_type_id'])) {
                $documentRows['document_type_id_' . $i] = $field['document_type_id'];
            }
            if (isset($field['document_number'])) {
                $documentRows['document_number_' . $i] = $field['document_number'];
            }

            $i++;
        }

        // flash data to session to populate field
        $flash = array_merge($flash, $relationshipRows);
        $flash = array_merge($flash, $documentRows);
        Session::flashInput($flash);
    }

    public function customFields()
    {
        return $this->customFields;
    }

    public function relationshipRows()
    {
        return $this->relationshipRows;
    }

    public function documentRows()
    {
        return $this->documentRows;
    }

    public function getDropdownValues($sql)
    {
        return $this->repository->getDropdownValues($sql);
    }
}
