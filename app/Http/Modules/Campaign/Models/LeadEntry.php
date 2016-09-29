<?php

namespace App\Http\Modules\Campaign\Models;

use App\Http\Models\Model;

class LeadEntry extends Model
{
    protected $screenId = '/cabinet/lead---quick-entry';

    protected $repositoryNamespace = 'App\Http\Modules\Campaign\Repositories\LeadEntryRepository';
}
