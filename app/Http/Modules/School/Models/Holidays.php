<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;

class Holidays extends Model
{
    protected $screenId = '/cabinet/holidays';

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\HolidaysRepository';

    public function setAccountIdsAttribute($value)
    {
        $this->setAttribute('dateID_description_list', $value);
        return $value;
    }

    public function setMiAttribute($value)
    {
        $this->setAttribute('month_id', $value);
        return $value;
    }

    public function rows()
    {
        if (is_null($this->fi)) {
            return [];
        }
        return $this->repository->getHolidays($this->month_id);
    }
}
