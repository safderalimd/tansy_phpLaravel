<?php

namespace App\Http\Modules\CRM\Models;

use App\Http\Models\Model;

class ClientVisit extends Model
{
    protected $screenId = 4001;

    protected $repositoryNamespace = 'App\Http\Modules\CRM\Repositories\ClientVisitRepository';

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
