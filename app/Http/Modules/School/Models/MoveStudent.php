<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;

class MoveStudent extends Model
{
    protected $screenId = 3006;

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\MoveStudentRepository';

    protected $selects = [
        'move_to_fiscal_year_entity_id',
        'move_to_class_entity_id',
    ];

    public function move()
    {
        return $this->repository->move($this);
    }
}
