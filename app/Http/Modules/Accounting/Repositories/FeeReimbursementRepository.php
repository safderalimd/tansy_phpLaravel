<?php

namespace App\Http\Modules\Accounting\Repositories;

use App\Http\Repositories\Repository;

class FeeReimbursementRepository extends Repository
{
    public function getAllReimbursements($model)
    {
        $procedure = 'sproc_act_rcv_due_lst_reimbursement';

        $iparams = [
            ':iparam_subject_entity_id',
            '-iparam_return_type',
            ':iparam_product_entity_id',
            ':iparam_fiscal_year_entity_id',
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
        $procedure = 'sproc_act_rcv_generate_receipt_multiple_dml';

        $iparams = [
            '-iparam_aID_schID_dtID_tAmt_pAmt_rcpNm_rcpDt_list',
            ':iparam_product_entity_id',
            ':iparam_fiscal_year_entity_id',
            ':iparam_payment_type_id',
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
