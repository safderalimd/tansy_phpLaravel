<?php

namespace App\Http\Modules\Product\Models;

use App\Http\Models\Model;

class Product extends Model
{
    protected $screenId = 2003;

    protected $repositoryNamespace = 'App\Http\Modules\Product\Repositories\ProductRepository';

    public $selectedFacilities;

    public function setActiveAttribute($value)
    {
        $value = (string)$value;
        if (!empty($value) || $value == 'on') {
            return 1;
        }

        return 0;
    }

    public function setUnitRateAttribute($value)
    {
        return round(floatval($value), 2);
    }

    public function loadData()
    {
        $facilities = $this->repository->getSelectedFacilities($this->product_entity_id);
        $this->selectedFacilities = array_column($facilities, 'facility_entity_id');
        if (!is_array($this->selectedFacilities)) {
            $this->selectedFacilities = [];
        }
    }
}
