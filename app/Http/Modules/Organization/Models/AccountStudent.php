<?php

namespace App\Http\Modules\Organization\Models;

use App\Http\Models\Model;

class AccountStudent extends Model
{
    protected $screenId = 3005;

    protected $repositoryNamespace = 'App\Http\Modules\Organization\Repositories\AccountStudentRepository';

    public function setActiveToFalse()
    {
        $this->attributes['active'] = 0;
    }

    public function setLoginActiveToFalse()
    {
        $this->attributes['login_active'] = 0;
    }

    public function setActiveAttribute($value)
    {
        $value = (string)$value;
        if (!empty($value) || $value == 'on') {
            return 1;
        }

        return 0;
    }

    public function setLoginActiveAttribute($value)
    {
        $value = (string)$value;
        if (!empty($value) || $value == 'on') {
            return 1;
        }

        return 0;
    }
}
