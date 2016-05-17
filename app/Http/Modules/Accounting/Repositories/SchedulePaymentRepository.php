<?php

namespace App\Http\Modules\Accounting\Repositories;

use App\Http\Repositories\Repository;

class SchedulePaymentRepository extends Repository
{
    public function getModelById($id)
    {
        return $this->db()->select(
            'SELECT
                schedule_entity_id,
                subject_entity_id,
                product_entity_id,
                frequency_id,
                schedule_name,
                amount,
                start_date,
                end_date,
                due_date_days_value,
                entity_type_id,
                active
             FROM view_act_rcv_schedule_detail
             WHERE schedule_entity_id = :id
             LIMIT 1;', ['id' => $id]
        );
    }

    public function insert($model)
    {
        $procedure = 'sproc_act_rcv_schedule_dml_ins';

        $iparams = [
            ':iparam_subject_entity_id',
            ':iparam_product_entity_id',
            ':iparam_frequency_id',
            ':iparam_schedule_name',
            ':iparam_amount',
            ':iparam_start_date',
            ':iparam_end_date',
            ':iparam_due_date_days_value',
            ':iparam_facility_ids',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_schedule_entity_id',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->runProcedure($model, $procedure, $iparams, $oparams);
    }

    public function update($model)
    {
        $procedure = 'sproc_act_rcv_schedule_dml_upd';

        $iparams = [
            ':iparam_schedule_entity_id',
            ':iparam_subject_entity_id',
            ':iparam_product_entity_id',
            ':iparam_frequency_id',
            ':iparam_schedule_name',
            ':iparam_amount',
            ':iparam_start_date',
            ':iparam_end_date',
            ':iparam_due_date_days_value',
            ':iparam_facility_ids',
            ':iparam_active',
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

        return $this->runProcedure($model, $procedure, $iparams, $oparams);
    }

    public function delete($model)
    {
        $procedure = 'sproc_act_rcv_schedule_dml_del';

        $iparams = [
            ':iparam_schedule_entity_id',
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

        return $this->runProcedure($model, $procedure, $iparams, $oparams);
    }
}
