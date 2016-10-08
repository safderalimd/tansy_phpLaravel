<?php

namespace App\Http\Models\Traits;

trait OwnerOrganization
{
    protected $organizationName;

    protected $organizationLine2;

    protected $organizationLine3;

    protected $organizationWebsite;

    public function setOwnerOrganizationInfo()
    {
        $org = $this->ownerOrganization();
        $this->organizationName = isset($org[0]['organization_name']) ? $org[0]['organization_name'] : '-';
        $this->organizationWebsite = isset($org[0]['website']) ? $org[0]['website'] : '';
        $this->organizationLine2 = isset($org[0]['report_header_line2']) ? $org[0]['report_header_line2'] : '';
        $this->organizationLine3 = isset($org[0]['report_header_line3']) ? $org[0]['report_header_line3'] : '';
    }

    public function organizationName()
    {
        return $this->organizationName;
    }

    public function organizationLine2()
    {
        return $this->organizationLine2;
    }

    public function organizationLine3()
    {
        return $this->organizationLine3;
    }

    public function organizationWebsite()
    {
        return $this->organizationWebsite;
    }
}
