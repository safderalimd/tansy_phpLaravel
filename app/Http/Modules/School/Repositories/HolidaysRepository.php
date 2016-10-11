<?php

namespace App\Http\Modules\School\Repositories;

use App\Http\Repositories\Repository;

class HolidaysRepository extends Repository
{
    public function getHolidays($model)
    {
        $procedure = 'sproc_org_holidays_grid';

        $iparams = [
            ':iparam_month_id',
        ];

        $oparams = [];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }

    public function update($model)
    {
        $procedure = 'sproc_org_holidays_dml';

        $iparams = [
            ':iparam_facility_entity_id',
            ':iparam_month_id',
            '-iparam_dateID_description_list',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }
}
