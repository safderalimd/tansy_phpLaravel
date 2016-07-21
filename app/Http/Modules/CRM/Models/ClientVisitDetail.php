<?php

namespace App\Http\Modules\CRM\Models;

use App\Http\Models\Model;

class ClientVisitDetail extends Model
{
    protected $screenId = '/cabinet/client-visit-details';

    protected $repositoryNamespace = 'App\Http\Modules\CRM\Repositories\ClientVisitRepository';
}
