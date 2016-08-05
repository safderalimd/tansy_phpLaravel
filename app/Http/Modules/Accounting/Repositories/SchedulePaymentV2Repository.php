<?php

namespace App\Http\Modules\Accounting\Repositories;

use App\Http\Repositories\Repository;

class SchedulePaymentV2Repository extends Repository
{
    public function update($model)
    {
        $procedure = 'sproc_act_rcv_schedule_payment_multiple_dml';

        $iparams = [
            '-iparam_actEID_schAmnt_list',
            ':iparam_frequency_id',
            ':iparam_product_entity_id',
            '-iparam_start_date',
            '-iparam_end_date',
            ':iparam_default_facility_id', // iparam_default_facility_entity_id
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
