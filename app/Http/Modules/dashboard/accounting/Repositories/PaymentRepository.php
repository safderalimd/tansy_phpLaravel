<?php

namespace App\Http\Modules\dashboard\accounting\Repositories;

use App\Http\Repositories\Repository;

class PaymentRepository extends Repository
{
    public function getDetailCurrentFiscal()
    {
        // account_name, credit_date, adjustment_amount, schedule_name
        return $this->lookup('sproc_act_adjustment_detail_current_fiscal');
    }

    public function getScheduleDetail()
    {
        return $this->select(
            'SELECT
                schedule_entity_id,
                subject_entity_id,
                product_entity_id,
                frequency_id,
                due_date_days_value,
                schedule_name,
                start_date,
                end_date,
                amount,
                active,
                product_name,
                frequency,
                scheduled_for
            FROM view_act_rcv_schedule_detail
            ORDER BY schedule_name ASC;'
        );
    }

    public function dueList($model)
    {
        $procedure = 'sproc_act_rcv_due_lst';

        $iparams = [
            '-iparam_filter_type',
            ':iparam_subject_entity_id',
            '-iparam_return_type',
            ':iparam_product_entity_id',
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

    public function feePayment($model)
    {
        $procedure = 'sproc_dsh_sch_fee_payment_v1';

        $iparams = [
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_scheduled_amount',
            '@oparam_collection_amount',
            '@oparam_due_amount', // not used anymore
            '@oparam_discount_amount',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function collection($model)
    {
        $procedure = 'sproc_dsh_sch_fee_payment_collection_v1';

        $iparams = [
            '-iparam_filter_type',
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
