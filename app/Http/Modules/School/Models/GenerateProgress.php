<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;

class GenerateProgress extends Model
{
    protected $screenId = 3010;

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\GenerateProgressRepository';

    public function generate()
    {
        return $this->repository->generateProgress($this);
    }
}
