<?php

namespace App\Http\Modules\Admin\Models;

use App\Http\Models\Model;

class Admin extends Model
{
    protected $screenId = 1003;

    protected $repositoryNamespace = 'App\Http\Modules\Admin\Repositories\AdminRepository';

    public function __construct($arguments = [])
    {
        parent::__construct($arguments);

        $this->repository->homeData($this);
    }
}
