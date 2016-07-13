<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;

class Exam extends Model
{
    protected $screenId = '/cabinet/exam';

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\ExamRepository';

    protected $selects = [
        'exam_type_id',
        'facility_ids',
    ];

    public $selectedFacilities;

    public function setActiveAttribute($value)
    {
        $value = (string)$value;
        if (!empty($value) || $value == 'on') {
            return 1;
        }

        return 0;
    }

    public function loadData()
    {
        $facilities = $this->repository->getSelectedFacilities($this->exam_entity_id);
        $this->selectedFacilities = array_column($facilities, 'facility_entity_id');
        if (!is_array($this->selectedFacilities)) {
            $this->selectedFacilities = [];
        }
    }
}
