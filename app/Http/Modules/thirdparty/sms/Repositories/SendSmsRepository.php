<?php

namespace App\Http\Modules\thirdparty\sms\Repositories;

use App\Http\Repositories\Repository;

class SendSmsRepository extends Repository
{
    public function smsBalanceCount()
    {
        return $this->select(
            'SELECT * FROM view_sms_balance_count LIMIT 1;'
        );
    }

    public function getSmsTypes()
    {
        return $this->select(
            'SELECT
                sms_type,
                sms_type_id
            FROM view_sms_lkp_sms_type
            ORDER BY sms_type ASC;'
        );
    }

    public function getSmsAccountTypes()
    {
        return $this->select(
            'SELECT
                row_type,
                entity_id,
                drop_down_list_name,
                sequence_id,
                reporting_order
            FROM view_sms_lkp_account_type
            ORDER BY sequence_id, reporting_order ASC;'
        );
    }

    public function feeReminders($model)
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
            '@oparam_err_msg'
        ];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }
}
