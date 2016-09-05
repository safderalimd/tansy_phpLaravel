<?php

namespace App\Http\Modules\Teacher\Models;

use App\Http\Models\Model;

class TeacherSubjectMap extends Model
{
    protected $screenId = '/cabinet/teacher-subject-map';

    protected $repositoryNamespace = 'App\Http\Modules\Teacher\Repositories\TeacherSubjectMapRepository';

    public function setEidAttribute($value)
    {
        $this->setAttribute('individual_entity_id', $value);
        return $value;
    }

    public function setSidAttribute($value)
    {
        $this->setAttribute('subject_entity_id', $value);
        return $value;
    }

    public function rows()
    {
        if (is_null($this->individual_entity_id) || is_null($this->subject_entity_id)) {
            return [];
        }

        return $this->repository->getGrid($this);
    }
}
