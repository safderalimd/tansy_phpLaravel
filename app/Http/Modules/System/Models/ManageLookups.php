<?php

namespace App\Http\Modules\System\Models;

use App\Http\Models\Model;

class ManageLookups extends Model
{
    protected $screenId = '/cabinet/manage-lookups';

    protected $repositoryNamespace = 'App\Http\Modules\System\Repositories\ManageLookupsRepository';

    protected $rows = [];

    public function setLkiAttribute($value)
    {
        $this->setAttribute('lookup_id', $value);
        return $value;
    }

    public function setActiveAttribute($value)
    {
        if ($value == 'ture') {
            return 1;
        }
        return 0;
    }

    public function loadData()
    {
        if (is_null($this->lookup_id)) {
            $this->rows = [];
            return;
        }

        $this->rows = $this->repository->lookupGrid($this);
    }

    public function rows()
    {
        return $this->rows;
    }

    public function firstRow()
    {
        return isset($this->rows[0]) ? $this->rows[0] : [];
    }

    public function hasAddButton()
    {
        if (isset($this->rows[0]['show_add_new_button']) && $this->rows[0]['show_add_new_button'] == 1) {
            return true;
        }

        return false;
    }
}
