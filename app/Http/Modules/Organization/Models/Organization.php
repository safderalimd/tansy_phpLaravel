<?php

namespace App\Http\Modules\Organization\Models;

use App\Http\Models\Model;

class Organization extends Model
{
    protected $screenId = '/cabinet/organizations';

    protected $repositoryNamespace = 'App\Http\Modules\Organization\Repositories\OrganizationRepository';

    protected $selects = [
        'organization_type_id',
        'city_id',

        'facility_type_id',
        'facility_city_id',
    ];

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
