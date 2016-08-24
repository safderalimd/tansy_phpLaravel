<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;
use Session;

class ProgressGrade extends Model
{
    protected $screenId = '/cabinet/progress-grade';

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\ProgressGradeRepository';

    // protected $selects = [
    //     'event_type_id',
    // ];

    public function gradeSystems()
    {
        return $this->repository->gradeSystems($this);
    }

    // public function grid()
    // {
    //     if (is_null($this->st) || is_null($this->en)) {
    //         return [];
    //     }

    //     $this->setAttribute('start_date', $this->st);
    //     $this->setAttribute('end_date', $this->en);
    //     $data = $this->repository->getGrid($this);
    //     return first_resultset($data);
    // }

    // public function setDetail($id)
    // {
    //     $this->setAttribute('event_id', $id);
    //     $data = $this->repository->detail($this);
    //     if (isset($data[0])) {
    //         $data = $data[0];
    //     }
    //     // $data['exam_name'] = isset($data['exam']) ? $data['exam'] : '';
    //     // $items = array_merge($this->attributes, $data);
    //     Session::flashInput($this->attributes);
    //     $this->isNewRecord = false;
    // }
}
