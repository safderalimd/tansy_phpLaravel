<?php

namespace App\Http\Modules\Accounting\Repositories;

use App\Http\Repositories\Repository;

class SchedulePaymentV2Repository extends Repository
{

    // set @iparam_actEID_schAmnt_list ='103$<>$134.01|104$<>$933.33';
    // SET @iparam_product_entity_id = '27';
    // set @iparam_start_date ='2016-7-1';
    // set @iparam_default_facility_entity_id = 2;

    public function update($model)
    {
        $procedure = 'sproc_act_rcv_schedule_payment_multiple_dml';

        $iparams = [
            '-iparam_actEID_schAmnt_list',
            ':iparam_product_entity_id',
            '-iparam_start_date',
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
