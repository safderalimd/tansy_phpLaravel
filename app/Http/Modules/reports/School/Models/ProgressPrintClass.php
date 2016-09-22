<?php

namespace App\Http\Modules\reports\School\Models;

use App\Http\Models\Model;
use App\Http\Models\Traits\OwnerOrganization;

class ProgressPrintClass extends Model
{
    protected $screenId = '/cabinet/pdf---class-progress';

    protected $repositoryNamespace = 'App\Http\Modules\reports\School\Repositories\ProgressPrintClassRepository';

    use OwnerOrganization;

    public function getPdfData()
    {
        $this->setOwnerOrganizationInfo();
        $data = $this->repository->getProgressList($this);
        return new SchoolProgress($data);
    }
}
