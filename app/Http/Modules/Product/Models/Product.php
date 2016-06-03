<?php

namespace App\Http\Modules\Product\Models;

use App\Http\Models\Model;

class Product extends Model
{
    protected $screenId = 2003;

    protected $repositoryNamespace = 'App\Http\Modules\Product\Repositories\ProductRepository';

    public function setActiveAttribute($value)
    {
        $value = parse_str($value);
        if (!empty($value) || $value == 'on') {
            return 1;
        }

        return 0;
    }

    public function setUnitRateAttribute($value)
    {
        return round(floatval($value), 2);
    }
}
