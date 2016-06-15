<?php

namespace App\Http\Modules\Accounting\Models;

use App\Http\Models\Model;

class SchedulePayment extends Model
{
    protected $screenId = 2011;

    protected $repositoryNamespace = 'App\Http\Modules\Accounting\Repositories\SchedulePaymentRepository';

    public $selectedFacilities;

    public function setActiveAttribute($value)
    {
        $value = (string)$value;
        if (!empty($value) || $value == 'on') {
            return 1;
        }

        return 0;
    }

    public function loadData()
    {
        $facilities = $this->repository->getSelectedFacilities($this->schedule_entity_id);
        $this->selectedFacilities = array_column($facilities, 'facility_entity_id');
        if (!is_array($this->selectedFacilities)) {
            $this->selectedFacilities = [];
        }
    }
}
