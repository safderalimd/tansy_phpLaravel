<?php

namespace App\Http\Modules\dashboard\sms\Repositories;

use App\Http\Repositories\Repository;

class SmsRepository extends Repository
{
    public function smsDetails($model)
    {
        $procedure = 'sproc_dsh_sms_v1';

        $iparams = [
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_total_sms_purchase_count',
            '@oparam_total_sms_send_count',
            '@oparam_total_sms_balance_count',
            '@oparam_sms_success_rate',
            '@oparam_accounts_with_valid_sms_count',
            '@oparam_accounts_with_invalid_sms_count',
            '@oparam_accounts_with_no_sms_count',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    // public function collection($model)
    // {
    //     $procedure = 'sproc_dsh_sch_fee_payment_collection_v1';

    //     $iparams = [
    //         ':iparam_filter_type',
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

    //     return $this->procedure($model, $procedure, $iparams, $oparams);
    // }

    // public function getDetailCurrentFiscal()
    // {
    //     return $this->select(
    //         'SELECT
    //             account_name,
    //             credit_date,
    //             adjustment_amount
    //         FROM view_act_adjustment_detail_current_fiscal
    //         ORDER BY account_name;'
    //     );
    // }
}
