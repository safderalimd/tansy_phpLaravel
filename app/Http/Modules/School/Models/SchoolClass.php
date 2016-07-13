<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;

class SchoolClass extends Model
{
    protected $screenId = '/cabinet/class';

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\SchoolClassRepository';

    protected $selects = [
        'class_group_entity_id',
        'class_category_entity_id',
        'class_teacher_entity_id',
        'facility_ids',
    ];

    public function setActiveAttribute($value)
    {
        $value = (string)$value;
        if (!empty($value) || $value == 'on') {
            return 1;
        }

        return 0;
    }
}
