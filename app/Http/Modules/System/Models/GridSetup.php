<?php

namespace App\Http\Modules\System\Models;

use App\Http\Models\Model;

class GridSetup extends Model
{
    protected $screenId = '/cabinet/grid-setup';

    protected $repositoryNamespace = 'App\Http\Modules\System\Repositories\GridSetupRepository';

    public function customGrids()
    {
        return $this->repository->customGrids($this);
    }

    public function rows()
    {
        if (is_null($this->gsi)) {
            return [];
        }

        $this->setAttribute('filter_screen_id', $this->gsi);
        return $this->repository->gridSetup($this);
    }

    public function updateGridSetup()
    {
        return $this->repository->updateGridSetup($this);
    }
}
