<?php

namespace App\Http\Modules\School\Repositories;

use App\Http\Repositories\Repository;

class AttendanceRepository extends Repository
{

    public function getAbsenteeAccountTypes()
    {
        return $this->select(
            'SELECT
                row_type,
                entity_id,
                drop_down_list_name,
                sequence_id,
                reporting_order
             FROM view_org_lkp_account_type_for_absentee
             ORDER BY sequence_id, reporting_order ASC;'
        );
    }

    public function attendance($model)
    {
        $procedure = 'sproc_org_individual_absentee_grid';

        $iparams = [
            '-iparam_filter_type',
            ':iparam_filter_entity_id',
            '-iparam_absense_date',
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

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }

    public function update($model)
    {
        $procedure = 'sproc_org_individual_absentee_dml';

        $iparams = [
            '-iparam_absense_date',
            '-iparam_IndvEntityIDs_absent_list',
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
