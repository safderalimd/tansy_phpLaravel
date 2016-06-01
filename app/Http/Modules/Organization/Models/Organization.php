<?php

namespace App\Http\Modules\Organization\Models;

use App\Http\Models\Model;

class Organization extends Model
{
    protected $screenId = 2002;

    protected $repositoryNamespace = 'App\Http\Modules\Organization\Repositories\OrganizationRepository';

    public function setActiveAttribute($value)
    {
        if (!empty($value) || $value == 'on') {
            return 1;
        }

        return 0;
    }
}
