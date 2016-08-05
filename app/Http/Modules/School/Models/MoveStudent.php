<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;

class MoveStudent extends Model
{
    protected $screenId = '/cabinet/move-student';

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\MoveStudentRepository';

    protected $selects = [
        'move_to_fiscal_year_entity_id',
        'move_to_class_entity_id',
    ];

    public function studentsGrid()
    {
        if (is_null($this->cei)) {
            return [];
        }

        return $this->repository->getStudentsGrid($this->cei);
    }

    public function move()
    {
        return $this->repository->move($this);
    }
}
