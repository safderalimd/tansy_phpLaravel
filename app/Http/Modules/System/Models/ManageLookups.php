<?php

namespace App\Http\Modules\System\Models;

use App\Http\Models\Model;

class ManageLookups extends Model
{
    protected $screenId = '/cabinet/manage-lookups';

    protected $repositoryNamespace = 'App\Http\Modules\System\Repositories\ManageLookupsRepository';
}
