<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;

class SchoolClass extends Model
{
    protected $screenId = 3007;

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\SchoolClassRepository';

    public function setActiveAttribute($value)
    {
        $value = (string)$value;
        if (!empty($value) || $value == 'on') {
            return 1;
        }

        return 0;
    }
}
