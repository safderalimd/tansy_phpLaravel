<?php

namespace App\Http\Modules\Accounting\Repositories;

use App\Http\Repositories\Repository;

class PaymentRepository extends Repository
{
    public function getAllPayments($model)
    {
        $procedure = 'sproc_act_rcv_due_lst';

        $iparams = [
            ':iparam_filter_type',
            ':iparam_subject_entity_id',
            ':iparam_return_type',
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

    public function payNow($model)
    {
        $procedure = 'sproc_act_rcv_generate_receipt_dml';

        $iparams = [
            ':iparam_schEntID_dateID_schAmnt_PaidAmnt_list',
            ':iparam_credited_to_entity_id',
            ':iparam_total_paid_amount',
            ':iparam_new_balance',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_receipt_id',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg'
        ];

        return $this->runProcedure($model, $procedure, $iparams, $oparams);
    }
}
