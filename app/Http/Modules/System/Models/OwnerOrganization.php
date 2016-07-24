<?php

namespace App\Http\Modules\System\Models;

use App\Http\Models\Model;

class OwnerOrganization extends Model
{
    protected $screenId = '/cabinet/my-org';

    protected $repositoryNamespace = 'App\Http\Modules\System\Repositories\OwnerOrganizationRepository';
}
