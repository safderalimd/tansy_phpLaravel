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
                collection_amount
             FROM view_act_rcv_close_cash_counter;'
        );
    }

    // public function getAllPayments($model)
    // {
    //     $procedure = 'sproc_act_rcv_due_lst';

    //     $iparams = [
    //         ':iparam_filter_type',
    //         ':iparam_subject_entity_id',
    //         ':iparam_return_type',
    //         ':iparam_session_id',
    //         ':iparam_user_id',
    //         ':iparam_screen_id',
    //         ':iparam_debug_sproc',
    //         ':iparam_audit_screen_visit',
    //     ];

    //     $oparams = [
    //         '@oparam_err_flag',
    //         '@oparam_err_step',
    //         '@oparam_err_msg',
    //     ];

    //     $data = $this->procedure($model, $procedure, $iparams, $oparams);
    //     return first_resultset($data);
    // }
}
