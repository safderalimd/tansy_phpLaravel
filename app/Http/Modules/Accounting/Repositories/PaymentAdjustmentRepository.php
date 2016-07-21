<?php

namespace App\Http\Modules\Accounting\Repositories;

use App\Http\Repositories\Repository;

class PaymentAdjustmentRepository extends Repository
{
    public function getAll($model)
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

    public function insert($model)
    {
        $procedure = 'sproc_act_rcv_adjustment_dml_ins';

        $iparams = [
            ':iparam_schedule_entity_id',
            ':iparam_date_id',
            ':iparam_credited_to_entity_id',
            ':iparam_payment_type_id',
            '+iparam_adjustment_amount',
            '+iparam_total_scheduled_amount',
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

    public function update($model)
    {
        $procedure = 'sproc_act_rcv_adjustment_dml_upd';

        $iparams = [
            ':iparam_schedule_detail_id',
            ':iparam_schedule_entity_id',
            ':iparam_date_id',
            ':iparam_credited_to_entity_id',
            ':iparam_payment_type_id',
            '+iparam_adjustment_amount',
            '+iparam_total_scheduled_amount',
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

    public function delete($model)
    {
        $procedure = 'sproc_act_rcv_adjustment_dml_del';

        $iparams = [
            ':iparam_schedule_detail_id',
            ':iparam_schedule_entity_id',
            ':iparam_date_id',
            ':iparam_credited_to_entity_id',
            '+iparam_total_scheduled_amount',
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
