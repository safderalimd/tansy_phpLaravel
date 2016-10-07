<?php

namespace App\Http\Modules\Accounting\Repositories;

use App\Http\Repositories\Repository;

class PaymentRepository extends Repository
{
    public function getShowReceiptOnPayment()
    {
        return $this->lookup('sproc_act_lkp_show_receipt_on_payment');
    }

    public function getSmsReceiptSettings()
    {
        return $this->lookup('sproc_sys_lkp_variables');

        // return $this->select(
        //     'SELECT
        //         send_payment_sms,
        //         payment_receipt_sms_type_id
        //      FROM view_sys_lkp_variables
        //      LIMIT 1;'
        // );
    }

    public function getIsCashCounterClosed()
    {
        return $this->lookup('sproc_act_rcv_lkp_closed_cash_counter_for_the_day');
    }

    public function getAllPayments($model)
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

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }

    public function payNow($model)
    {
        $procedure = 'sproc_act_rcv_generate_receipt_dml';

        $iparams = [
            '-iparam_schEntID_dateID_schAmnt_PaidAmnt_list',
            ':iparam_credited_to_entity_id',
            '+iparam_total_paid_amount',
            '+iparam_new_balance',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_receipt_id',
            '@oparam_show_receipt_pdf',
            '@oparam_receipt_pdf_version',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function getReceiptDetail($id)
    {
        return $this->select(
            'SELECT
                receipt_id,
                credit_amount,
                description
            FROM view_act_rcv_receipt_detail
            WHERE receipt_id = :id;', ['id' => $id]
        );
    }

    public function getReceiptHeader($id)
    {
        return $this->select(
            'SELECT
                receipt_id,
                receipt_number,
                receipt_date,
                receipt_amount,
                new_balance,
                paid_by_name,
                mobile_phone
            FROM view_act_rcv_receipt_header
            WHERE receipt_id = :id;', ['id' => $id]
        );
    }
}
