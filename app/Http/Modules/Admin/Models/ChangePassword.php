<?php

namespace App\Http\Modules\Admin\Models;

use App\Http\Models\Model;

class ChangePassword extends Model
{
    protected $screenId = 1002;

    protected $repositoryNamespace = 'App\Http\Modules\Admin\Repositories\ChangePasswordRepository';
}
