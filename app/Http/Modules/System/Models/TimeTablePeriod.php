<?php

namespace App\Http\Modules\System\Models;

use App\Http\Models\Model;

class TimeTablePeriod extends Model
{
    protected $screenId = '/cabinet/time-table-period';

    protected $repositoryNamespace = 'App\Http\Modules\System\Repositories\TimeTablePeriodRepository';

    protected $rows = [];

    protected $selects = [
        'period_type_id',
    ];

    public function setActiveAttribute($value)
    {
        if ($value == 'true') {
            return 1;
        }
        return 0;
    }

    public function loadData()
    {
        $this->rows = $this->repository->getGrid();
    }

    public function rows()
    {
        return $this->rows;
    }
}
