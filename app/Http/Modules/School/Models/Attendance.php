<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;

class Attendance extends Model
{
    protected $screenId = 2017;

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\AttendanceRepository';

    public $attendanceList;

    public function setHiddenAbsenseDateAttribute($value)
    {
        $this->setAttribute('absense_date', $value);
        return $value;
    }

    public function setAccountIdsAttribute($value)
    {
        $this->setAttribute('IndvEntityIDs_absent_list', $value);
        return $value;
    }

    public function setAeiAttribute($value)
    {
        $this->setAttribute('filter_entity_id', $value);
        return $value;
    }

    public function setArtAttribute($value)
    {
        $this->setAttribute('filter_type', $value);
        return $value;
    }

    public function setDtAttribute($value)
    {
        $this->setAttribute('absense_date', $value);
        return $value;
    }

    public function loadData()
    {
        if (!isset($this->absense_date)) {
            $this->setAttribute('absense_date', date('Y-m-j'));
        }

        $this->attendanceList = $this->attendanceList();
    }

    public function attendanceList()
    {
        if (!is_null($this->filter_type) && !is_null($this->filter_entity_id) && !is_null($this->absense_date)) {
            return $this->repository->attendance($this);
        }

        return [];
    }
}
