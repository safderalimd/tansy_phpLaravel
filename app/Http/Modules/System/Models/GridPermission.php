<?php

namespace App\Http\Modules\System\Models;

use App\Http\Models\Model;

class GridPermission extends Model
{
    protected $screenId = '/cabinet/grid-permission';

    protected $repositoryNamespace = 'App\Http\Modules\System\Repositories\GridPermissionRepository';

    public function customGrids()
    {
        return $this->repository->customGrids($this);
    }

    public function securityGroup()
    {
        return $this->repository->securityGroup($this);
    }

    public function rows()
    {
        if (is_null($this->gsi) || is_null($this->gei)) {
            return [];
        }

        $this->setAttribute('filter_screen_id', $this->gsi);
        return $this->repository->gridPermission($this);
    }

    public function updatePermissions()
    {
        $this->setAttribute('filter_screen_id', $this->gsi);
        $this->setAttribute('group_entity_id', $this->gei);
        return $this->repository->updatePermissions($this);
    }
}
