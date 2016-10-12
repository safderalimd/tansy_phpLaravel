<?php

namespace App\Http\Modules\reports\School\Models;

use App\Http\Models\Model;
use App\Http\Models\Traits\OwnerOrganization;

class DICE extends Model
{
    protected $screenId = '/cabinet/pdf---dice';

    protected $repositoryNamespace = 'App\Http\Modules\reports\School\Repositories\DICERepository';

    use OwnerOrganization;

    public $reportName = 'DICE';

    public function dice()
    {
        $dice = collect($this->repository->getDice($this));
        return $dice->groupBy('class_name');
    }
}
