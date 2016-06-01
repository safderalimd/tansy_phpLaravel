<?php

namespace App\Http\Modules\School\Models;

use App\Http\Models\Model;

class Attendance extends Model
{
    protected $screenId = 2017;

    protected $repositoryNamespace = 'App\Http\Modules\School\Repositories\AttendanceRepository';
}
