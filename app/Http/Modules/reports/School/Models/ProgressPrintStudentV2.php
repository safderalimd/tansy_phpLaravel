<?php

namespace App\Http\Modules\reports\School\Models;

use App\Http\Models\Model;
use App\Http\Modules\reports\School\Models\SchoolProgress;
use App\Http\Models\Traits\OwnerOrganization;

class ProgressPrintStudentV2 extends Model
{
    protected $screenId = '/cabinet/pdf---student-progress-v2';

    protected $repositoryNamespace = 'App\Http\Modules\reports\School\Repositories\ProgressPrintStudentV2Repository';

    use OwnerOrganization;

    public function getPdfData()
    {
        $data = $this->repository->getProgressList($this);
        return new SchoolProgress($data);
    }
}
