<?php

namespace App\Http\Modules\Organization\Models;

use App\Http\Models\Model;
use Session;

class AccountStudent extends Model
{
    protected $screenId = '/cabinet/student-account';

    protected $repositoryNamespace = 'App\Http\Modules\Organization\Repositories\AccountStudentRepository';

    protected $customFields;

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

        // load the edit form details
        $atr = first_resultset($data);
        if (isset($atr[0])) {
            $atr = $atr[0];

            $atr['student_first_name'] = isset($atr['first_name']) ? $atr['first_name'] : '';
            $atr['student_middle_name'] = isset($atr['middle_name']) ? $atr['middle_name'] : '';
            $atr['student_last_name'] = isset($atr['last_name']) ? $atr['last_name'] : '';
            $atr['student_gender'] = isset($atr['gender']) ? $atr['gender'] : '';
            $atr['student_date_of_birth'] = isset($atr['date_of_birth']) ? $atr['date_of_birth'] : '';
            $atr['admitted_class_entity_id'] = isset($atr['class_entity_id']) ? $atr['class_entity_id'] : '';
            $atr['view_default_facility_id'] = isset($atr['default_facility_id']) ? $atr['default_facility_id'] : '';
            $atr['security_group_entity_id'] = isset($atr['group_entity_id']) ? $atr['group_entity_id'] : '';
        }

        foreach ((array) $atr as $key => $value) {
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
        Session::flashInput($atr);

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
