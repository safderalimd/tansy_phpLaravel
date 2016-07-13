<?php

namespace App\Http\Modules\Accounting\Models;

use App\Http\Models\Model;

class SchedulePayment extends Model
{
    protected $screenId = '/cabinet/schedule-payment';

    protected $repositoryNamespace = 'App\Http\Modules\Accounting\Repositories\SchedulePaymentRepository';

    public $selectedFacilities;

    protected $selects = [
        'facility_ids',
        'product_entity_id',
        'account_type_id',
        'subject_entity_id',
        'frequency_id',
    ];

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
