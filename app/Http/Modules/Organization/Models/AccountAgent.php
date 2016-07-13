<?php

namespace App\Http\Modules\Organization\Models;

use App\Http\Models\Model;

class AccountAgent extends Model
{
    protected $screenId = '/cabinet/account-agent';

    protected $repositoryNamespace = 'App\Http\Modules\Organization\Repositories\AccountAgentRepository';

    protected $selects = [
        'organization_entity_id',
        'facility_ids',
        'city_id',
        'document_type_id',
        'security_group_entity_id',
        'view_default_facility_id',
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

    public function setLoginActiveAttribute($value)
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
