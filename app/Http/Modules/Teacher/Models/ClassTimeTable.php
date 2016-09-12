<?php

namespace App\Http\Modules\Teacher\Models;

use App\Http\Models\Model;

class ClassTimeTable extends Model
{
    protected $screenId = '/cabinet/class-time-table';

    protected $repositoryNamespace = 'App\Http\Modules\Teacher\Repositories\ClassTimeTableRepository';

    protected $isEnabled = false;

    public function isEnabled()
    {
        return $this->isEnabled;
    }

    public function setSdtAttribute($value)
    {
        $this->setAttribute('start_date', $value);
        return $value;
    }

    public function setCeiAttribute($value)
    {
        $this->setAttribute('account_entity_id', $value);
        $this->setAttribute('class_entity_id', $value);
        return $value;
    }

    public function classSubject()
    {
        $data = $this->repository->classSubject($this);
        return first_resultset($data);
    }

    public function rows()
    {
        if (is_null($this->start_date) || is_null($this->account_entity_id)) {
            return [];
        }

        $this->isEnabled = true;
        $rows = $this->repository->detail($this);
        return collect(first_resultset($rows));
        // return $rows->groupBy('calendar_date');
    }

    public function findSubject($rows, $periodName, $weekDay)
    {
        return $rows->first(function ($key, $value) use ($periodName, $weekDay) {
            if (!isset($value['day_name_of_week']) || !isset($value['period_name'])) {
                return false;
            }

            if ($weekDay != $value['day_name_of_week'] || $periodName != $value['period_name']) {
                return false;
            }

            return true;
        });
    }
}
