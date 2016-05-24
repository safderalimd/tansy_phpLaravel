<?php

namespace App\Http\Modules\Accounting\Repositories;

use App\Http\Repositories\Repository;

class PaymentAdjustmentRepository extends Repository
{
    public function getAll($model)
    {
        $pdo = $this->db()->getPdo();

        // Todo: protect against sql injection

        $pdo->query("set @iparam_filter_type = '{$model->filter_type}';");
        $pdo->query("set @iparam_subject_entity_id = '{$model->subject_entity_id}';");
        $pdo->query("set @iparam_return_type = '{$model->return_type}';");

        $pdo->query("set @iparam_session_id = '{$model->session_id}';");
        $pdo->query("set @iparam_user_id = '{$model->user_id}';");
        $pdo->query("set @iparam_screen_id = '{$model->screen_id}';");
        $pdo->query("set @iparam_debug_sproc = '{$model->debug_sproc}';");
        $pdo->query("set @iparam_audit_screen_visit = '{$model->audit_screen_visit}';");

        $sql = 'call sproc_act_rcv_due_lst(
            @iparam_filter_type,
            @iparam_subject_entity_id,
            @iparam_return_type,
            @iparam_session_id,
            @iparam_user_id,
            @iparam_screen_id,
            @iparam_debug_sproc,
            @iparam_audit_screen_visit,
            @oparam_err_flag,
            @oparam_err_step,
            @oparam_err_msg
        );';

        $stmt = $pdo->query($sql);

        $dataResults = [];
        do {
            $rows = $stmt->fetchAll();
            if ($rows) {
                $dataResults = array_merge($dataResults, $rows);
            }
        } while ($stmt->nextRowset());


        $sql = 'SELECT @oparam_err_flag, @oparam_err_step, @oparam_err_msg;';
        $stmt = $pdo->query($sql);
        $errorResults = [];
        do {
            $rows = $stmt->fetchAll();
            if ($rows) {
                $errorResults = array_merge($errorResults, $rows);
            }
        } while ($stmt->nextRowset());

        // TODO: check for errors

        return $dataResults;
    }

    public function insert($model)
    {
        $procedure = 'sproc_act_rcv_adjustment_dml_ins';

        $iparams = [
            ':iparam_schedule_entity_id',
            ':iparam_date_id',
            ':iparam_credited_to_entity_id',
            ':iparam_payment_type_id',
            ':iparam_adjustment_amount',
            ':iparam_total_scheduled_amount',
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

    public function update($model)
    {
        $procedure = 'sproc_act_rcv_adjustment_dml_upd';

        $iparams = [
            ':iparam_schedule_detail_id',
            ':iparam_schedule_entity_id',
            ':iparam_date_id',
            ':iparam_credited_to_entity_id',
            ':iparam_payment_type_id',
            ':iparam_adjustment_amount',
            ':iparam_total_scheduled_amount',
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
        $procedure = 'sproc_act_rcv_adjustment_dml_del';

        $iparams = [
            ':iparam_schedule_detail_id',
            ':iparam_schedule_entity_id',
            ':iparam_date_id',
            ':iparam_credited_to_entity_id',
            ':iparam_total_scheduled_amount',
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
