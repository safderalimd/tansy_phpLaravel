<?php

namespace App\Http\Modules\Organizations;

use App\Http\Modules\Organizations\Models\FiscalYear;
use DB;

class FiscalYearRepository
{
    public function getAllFiscalYears() {
        return DB::connection('secondDB')->select(
            'SELECT fiscal_year_entity_id, fiscal_year, start_date, end_date, current_fiscal_year
             FROM view_org_fiscal_year_detail
             ORDER BY start_date DESC;'
        );
    }

    public function getFacilities()
    {
        return DB::connection('secondDB')->select(
            'SELECT facility_entity_id, facility_name
             FROM view_org_facility_lkp
             ORDER BY facility_name;'
        );
    }
}
