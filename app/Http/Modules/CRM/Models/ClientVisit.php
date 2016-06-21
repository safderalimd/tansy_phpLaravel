<?php

namespace App\Http\Modules\CRM\Models;

use App\Http\Models\Model;

class ClientVisit extends Model
{
    protected $screenId = 4001;

    protected $repositoryNamespace = 'App\Http\Modules\CRM\Repositories\ClientVisitRepository';

    protected $selects = [
        'campaign_entity_id',
        'organization_entity_id',
        'facility_entity_id',
        'contact_entity_id',
        'agent_organization_entity_id',
        'agent_entity_id',
        'client_status_id',
        'product_entity_id',
        'unit_type_id',
        'visit_type_id',
        'next_visit_type_id',
        'facility_type_id',
        'facility_city_id',
        'organization_city_id',
    ];

    public $cities = [];

    public $cityAreas = [];

    public function loadData()
    {
        $this->cities = $this->repository->getCities();
        $this->cityAreas = $this->repository->getCityAreas();
    }

    public function setFlags()
    {
        $this->setOrganizationNewFlag();
        $this->setFacilityNewFlag();
        $this->setContactNewFlag();
    }

    public function setOrganizationNewFlag()
    {
        $value = $this->organization_new;
        $value = (!empty($value) || $value == 'on') ? 1 : 0;
        $this->setAttribute('new_organization_flag', $value);
    }

    public function setFacilityNewFlag()
    {
        $value = $this->facility_new;
        $value = (!empty($value) || $value == 'on') ? 1 : 0;
        $this->setAttribute('new_facility_flag', $value);
    }

    public function setContactNewFlag()
    {
        $value = $this->contact_new;
        $value = (!empty($value) || $value == 'on') ? 1 : 0;
        $this->setAttribute('new_organization_contact_flag', $value);
    }
}
