<?php

namespace App\Http\Modules\Admin\Models;

use App\Http\Models\Model;

class ChangePassword extends Model
{
    protected $screenId = '/cabinet/change-password';

    protected $repositoryNamespace = 'App\Http\Modules\Admin\Repositories\ChangePasswordRepository';
}
