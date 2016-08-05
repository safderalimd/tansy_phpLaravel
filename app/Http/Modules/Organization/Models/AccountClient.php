<?php

namespace App\Http\Modules\Organization\Models;

use App\Http\Models\Model;

class AccountClient extends Model
{
    protected $screenId = '/cabinet/account-client';

    protected $repositoryNamespace = 'App\Http\Modules\Organization\Repositories\AccountClientRepository';

    protected $selects = [
        'facility_ids',
        'unique_key_id',
        'city_id',
        'document_type_id',
    ];

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
        $facilities = $this->repository->getSelectedFacilities($this->account_entity_id);
        $this->selectedFacilities = array_column($facilities, 'facility_entity_id');
        if (!is_array($this->selectedFacilities)) {
            $this->selectedFacilities = [];
        }
    }
}
