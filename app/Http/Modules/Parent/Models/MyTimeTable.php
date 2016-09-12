<?php

namespace App\Http\Modules\Parent\Models;

use App\Http\Models\Model;

class MyTimeTable extends Model
{
    protected $screenId = '/cabinet/my-time-table';

    protected $repositoryNamespace = 'App\Http\Modules\Parent\Repositories\MyTimeTableRepository';

    protected $messages = [];

    protected $dayName = '';

    public function getDate()
    {
        return date('Y-m-j', $this->day);
    }

    public function loadData()
    {
        $this->setAttribute('start_date', $this->getDate());
        $this->setAttribute('end_date', $this->getDate());
        $data = $this->repository->timeTable($this);
        $this->messages = collect(first_resultset($data));
        $this->setDayName();
    }

    public function setDayName()
    {
        if (isset($this->messages[0]['day_name_of_week'])) {
            $this->dayName = $this->messages[0]['day_name_of_week'];
        } else {
            $this->dayName = date('l', $this->day);
        }
    }

    public function dayName()
    {
        return $this->dayName;
    }

    public function messages()
    {
        return $this->messages;
    }
}
