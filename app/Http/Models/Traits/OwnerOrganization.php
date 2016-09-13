<?php

namespace App\Http\Models\Traits;

trait OwnerOrganization
{
    protected $organizationName;

    protected $organizationPhone;

    public function setOwnerOrganizationInfo()
    {
        $org = $this->ownerOrganization();
        $this->organizationName = isset($org[0]['organization_name']) ? $org[0]['organization_name'] : '-';
        $this->organizationPhone = isset($org[0]['mobile_phone']) ? $org[0]['mobile_phone'] : '-';
    }

    public function organizationName()
    {
        return $this->organizationName;
    }

    public function organizationPhone()
    {
        return $this->organizationPhone;
    }
}
