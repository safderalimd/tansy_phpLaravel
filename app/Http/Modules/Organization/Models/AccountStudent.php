<?php

namespace App\Http\Modules\Organization\Models;

use App\Http\Models\Model;

class AccountStudent extends Model
{
    protected $screenId = 3005;

    protected $repositoryNamespace = 'App\Http\Modules\Organization\Repositories\AccountStudentRepository';

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
}
