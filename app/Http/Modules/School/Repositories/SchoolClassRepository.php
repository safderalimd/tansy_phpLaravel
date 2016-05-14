<?php

namespace App\Http\Modules\School\Repositories;

use App\Http\Modules\School\Models\SchoolClass;
use DB;

class SchoolClassRepository
{
    public function getAllSchoolCalsses() {
        return DB::connection('secondDB')->select(
            'SELECT  class_entity_id, class_name, class_group, class_category
             FROM view_sch_class_grid
             ORDER BY class_name DESC;'
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

    public function getClassGroups()
    {
        return DB::connection('secondDB')->select(
            'SELECT class_group_entity_id, class_group
             FROM view_sch_lkp_class_group
             ORDER BY class_group;'
        );
    }

    public function getClassCategories()
    {
        return DB::connection('secondDB')->select(
            'SELECT class_category_entity_id, class_category
             FROM view_sch_lkp_class_category
             ORDER BY class_category;'
        );
    }
}
