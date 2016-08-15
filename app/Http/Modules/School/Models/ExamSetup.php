<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;
use Session;

class ExamSetup extends Model
{
    protected $screenId = '/cabinet/exam-setup';

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\ExamSetupRepository';

    // protected $selects = [
    //     'exam_type_id',
    //     'facility_ids',
    // ];

    public function setEeiAttribute($value)
    {
        $this->setAttribute('exam_entity_id', $value);
        return $value;
    }

    public function examDropdown()
    {
        return $this->repository->examDropdown($this);
    }

    public function examSetupGrid()
    {
        if (is_null($this->exam_entity_id)) {
            return [];
        }

        $data = $this->repository->getExamSetupGrid($this);
        return first_resultset($data);
    }
}
