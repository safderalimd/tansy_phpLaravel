<?php

namespace App\Http\Modules\reports\School\Models;

use App\Http\Models\Model;
use App\Http\Models\Traits\OwnerOrganization;

class TimeTable extends Model
{
    protected $screenId = '/cabinet/pdf---time-table';

    protected $repositoryNamespace = 'App\Http\Modules\reports\School\Repositories\TimeTableRepository';

    use OwnerOrganization;

    public $dropdownFilter = '-';

    public $startDateFilter = '-';

    public $rows = [];

    public function setDtAttribute($value)
    {
        $this->setAttribute('start_date', $value);
        return $value;
    }

    public function loadData()
    {
        $this->setAttribute('account_entity_id', $this->aei);
        $this->rows = $this->repository->timeTable($this);
        $this->rows = collect(first_resultset($this->rows));

        $this->setOwnerOrganizationInfo();
        $this->setFilters();
    }

    public function setFilters()
    {
        foreach ($this->schoolAccountTypeFilter() as $option) {
            if ($this->account_entity_id == $option['entity_id']) {
                $this->dropdownFilter = $option['drop_down_list_name'];
                break;
            }
        }

        $this->startDateFilter = $this->start_date;
    }

    public function weekDays()
    {
        $days = $this->repository->getWeekDays();

        // put sunday at the end of the week
        if (isset($days[0])) {
            $sunday = array_shift($days);
            array_push($days, $sunday);
        }

        return $days;
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
