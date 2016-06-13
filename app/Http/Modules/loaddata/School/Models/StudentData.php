<?php

namespace App\Http\Modules\loaddata\School\Models;

use App\Http\Models\Model;

class StudentData extends Model
{
    protected $screenId = 3003;

    protected $repositoryNamespace = 'App\Http\Modules\loaddata\School\Repositories\StudentDataRepository';

    public function add($rows)
    {
        foreach ($rows as $row) {
            $this->repository->insert($row);
        }
    }

    public function uploadComplete()
    {
        return $this->repository->uploadComplete($this);
    }
}
