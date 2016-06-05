<?php

namespace App\Http\Modules\Organization\Models;

use App\Http\Models\Model;

class AccountAgent extends Model
{
    protected $screenId = 2006;

    protected $repositoryNamespace = 'App\Http\Modules\Organization\Repositories\AccountAgentRepository';

    public $selectedFacilities;

    public function setActiveAttribute($value)
    {
        $value = (string)$value;
        if (!empty($value) || $value == 'on') {
            return 1;
        }

        return 0;
    }

    public function setUserAccountActiveAttribute($value)
    {
        $value = (string)$value;
        if (!empty($value) || $value == 'on') {
            return 1;
        }

        return 0;
    }

    public function setFieldPasswordAttribute($value)
    {
        $this->setAttribute('password', $value);
        return $value;
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
