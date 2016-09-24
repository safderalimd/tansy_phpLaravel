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

    public function setCtiAttribute($value)
    {
        $this->setAttribute('teacher_account_entity_id', $value);
        return $value;
    }

    public function classSubject()
    {
        $data = $this->repository->classSubject($this);
        return first_resultset($data);
    }

    public function classSubjectTeacher()
    {
        $data = $this->repository->classSubjectTeacher($this);
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
    }

    public function teacherRows()
    {
        if (is_null($this->teacher_account_entity_id)) {
            return [];
        }

        $rows = $this->repository->teachersDetail($this);
        return collect(first_resultset($rows));
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

    /**
     * Show teacher or class type
     */
    public function showType()
    {
        return $this->entity_type;
    }
}
