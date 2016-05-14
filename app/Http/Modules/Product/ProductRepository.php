<?php

namespace App\Http\Modules\Product;

use App\Http\Modules\Product\Models\Product;
use DB;

class ProductRepository
{

    public function getAllProducts() {
        return DB::connection('secondDB')->select(
            'SELECT  product, product_type, unit_rate, product_type_entity_id, product_entity_id, active
             FROM view_prd_lkp_product
             ORDER BY product DESC;'
        );
    }

    public function getProductTypes()
    {
        return DB::connection('secondDB')->select(
            'SELECT product_type_entity_id, product_type
             FROM view_prd_lkp_product_type
             ORDER BY product_type;'
        );
    }

    public function getProductFacilities()
    {
        return DB::connection('secondDB')->select(
            'SELECT  facility_entity_id, facility_name
             FROM view_org_lkp_facility
             ORDER BY facility_name;'
        );
    }

}
