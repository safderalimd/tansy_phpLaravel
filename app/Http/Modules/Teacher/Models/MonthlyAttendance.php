<?php

namespace App\Http\Modules\Teacher\Models;

use App\Http\Models\Model;

class MonthlyAttendance extends Model
{
    protected $screenId = '/cabinet/monthly-attendance';

    protected $repositoryNamespace = 'App\Http\Modules\Teacher\Repositories\MonthlyAttendanceRepository';

    public function setAeiAttribute($value)
    {
        $this->setAttribute('filter_entity_id', $value);
        return $value;
    }

    public function setMiAttribute($value)
    {
        $this->setAttribute('month_id', $value);
        return $value;
    }

    public function rows()
    {
        if (is_null($this->filter_entity_id) || is_null($this->month_id)) {
            return [];
        }

        return $this->repository->grid($this);
    }
}
