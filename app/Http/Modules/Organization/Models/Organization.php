<?php

namespace App\Http\Modules\Organization\Models;

use App\Http\Models\Model;

class Organization extends Model
{
    protected $screenId = 2002;

    protected $repositoryNamespace = 'App\Http\Modules\Organization\Repositories\OrganizationRepository';

    public function setActiveAttribute($value)
    {
        $value = (string)$value;
        if (!empty($value) || $value == 'on') {
            return 1;
        }

        return 0;
    }

    public function setFacilityNewFlag()
    {
        $value = $this->create_new_facility;
        $value = (!empty($value) || $value == 'on') ? 1 : 0;
        $this->setAttribute('create_new_facility', $value);
    }

}
