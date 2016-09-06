<?php

namespace App\Http\Modules\reports\School\Models;

use App\Http\Models\Model;

class ProgressPrintStudent extends Model
{
    protected $screenId = '/cabinet/pdf---student-progress-v1';

    protected $repositoryNamespace = 'App\Http\Modules\reports\School\Repositories\ProgressPrintStudentRepository';

    public function getPdfData()
    {
        $data = $this->repository->getProgressList($this);
        return new SchoolProgress($data);
    }
}
