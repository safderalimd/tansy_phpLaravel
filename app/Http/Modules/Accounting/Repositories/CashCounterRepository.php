<?php

namespace App\Http\Modules\Accounting\Repositories;

use App\Http\Repositories\Repository;

class CashCounterRepository extends Repository
{
    public function getCashCounterRows()
    {
        return $this->select(
            'SELECT
                calendar_date,
                collection_amount,
                date_id
             FROM view_act_rcv_close_cash_counter;'
        );
    }

    public function closeCounter($model)
    {
        $procedure = 'sproc_act_rcv_close_cash_counter_dml';

        $iparams = [
            '-iparam_dateIDs_collections',
            ':iparam_default_facility_id',
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
