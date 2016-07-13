<?php

namespace App\Http\Modules\Organization\Models;

use App\Http\Models\Model;

class FiscalYear extends Model
{
    protected $screenId = '/cabinet/fiscal-year';

    protected $repositoryNamespace = 'App\Http\Modules\Organization\Repositories\FiscalYearRepository';

    public $selectedFacilities = null;

    public function setCurrentFiscalYearAttribute($value)
    {
        $value = (string)$value;
        if (!empty($value) || $value == 'on') {
            return 1;
        }

        return 0;
    }

    public function setFacilityIdsAttribute($value)
    {
        if (is_array($value)) {
            return implode(',', $value);
        }

        return '';
    }

    public function loadData()
    {
        $facilities = $this->repository->getSelectedFacilities($this->fiscal_year_entity_id);
        $this->selectedFacilities = array_column($facilities, 'facility_entity_id');
    }
}
