<?php

namespace App\Http\Modules\Teacher\Models;

use App\Http\Models\Model;

class TeacherQuickUpdate extends Model
{
    protected $screenId = '/cabinet/teacher---quick-update';

    protected $repositoryNamespace = 'App\Http\Modules\Teacher\Repositories\TeacherQuickUpdateRepository';

    protected $selects = [
        'row_department_id',
        'class_teacher_class_entity_id',
    ];

    public function setDiAttribute($value)
    {
        $this->setAttribute('department_id', $value);
        return $value;
    }

    public function rows()
    {
        if (is_null($this->department_id)) {
            return [];
        }
        
        $data = $this->repository->grid($this);
        return first_resultset($data);
    }
}
