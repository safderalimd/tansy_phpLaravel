<?php

namespace App\Http\Modules\Teacher\Models;

use App\Http\Models\Model;

class ClassTimeTable extends Model
{
    protected $screenId = '/cabinet/class-time-table';

    protected $repositoryNamespace = 'App\Http\Modules\Teacher\Repositories\ClassTimeTableRepository';

    // public function setSdtAttribute($value)
    // {
    //     $this->setAttribute('start_date', $value);
    //     return $value;
    // }

    // public function setEdtAttribute($value)
    // {
    //     $this->setAttribute('end_date', $value);
    //     return $value;
    // }

    // public function setCeiAttribute($value)
    // {
    //     $this->setAttribute('class_entity_id', $value);
    //     return $value;
    // }

    // public function rows()
    // {
    //     if (is_null($this->start_date) || is_null($this->end_date) || is_null($this->class_entity_id)) {
    //         return [];
    //     }

    //     return $this->repository->getGrid($this);
    // }
}
