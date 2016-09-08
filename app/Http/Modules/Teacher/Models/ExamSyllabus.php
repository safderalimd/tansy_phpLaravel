<?php

namespace App\Http\Modules\Teacher\Models;

use App\Http\Models\Model;

class ExamSyllabus extends Model
{
    protected $screenId = '/cabinet/exam-syllabus';

    protected $repositoryNamespace = 'App\Http\Modules\Teacher\Repositories\ExamSyllabusRepository';

    public function setEeiAttribute($value)
    {
        $this->setAttribute('exam_entity_id', $value);
        return $value;
    }

    public function setCeiAttribute($value)
    {
        $this->setAttribute('class_entity_id', $value);
        return $value;
    }

    public function rows()
    {
        if (is_null($this->exam_entity_id) || is_null($this->class_entity_id)) {
            return [];
        }

        return $this->repository->getGrid($this);
    }
}
