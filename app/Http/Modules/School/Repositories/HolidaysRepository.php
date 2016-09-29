<?php

namespace App\Http\Modules\School\Repositories;

use App\Http\Repositories\Repository;

class HolidaysRepository extends Repository
{
    public function getHolidays($id)
    {
        return $this->select(
            'SELECT
                calendar_date_name,
                holiday,
                description,
                date_id,
                month_id
             FROM view_org_holidays_grid
             WHERE month_id = :id
             ORDER BY calendar_date_name ASC;', ['id' => $id]
        );
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
