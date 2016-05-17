<?php

namespace App\Http\Modules\Accounting\Repositories;

use App\Http\Repositories\Repository;

class PaymentRepository extends Repository
{
    public function getAllPayments($model)
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





    public function getModelById($id)
    {
        // return $this->db()->select(
        //     'SELECT
        //         product AS product_name,
        //         product_type,
        //         unit_rate,
        //         product_type_entity_id,
        //         product_entity_id,
        //         active
        //      FROM view_prd_lkp_product
        //      WHERE product_entity_id = :id
        //      LIMIT 1;', ['id' => $id]
        // );
    }

    public function insert($model)
    {
        // $procedure = 'sproc_prd_product_dml_ins';

        // $iparams = [
        //     ':iparam_product_name',
        //     ':iparam_product_type_entity_id',
        //     ':iparam_unit_rate',
        //     ':iparam_facility_ids',
        //     ':iparam_session_id',
        //     ':iparam_user_id',
        //     ':iparam_screen_id',
        //     ':iparam_debug_sproc',
        //     ':iparam_audit_screen_visit',
        // ];

        // $oparams = [
        //     '@oparam_product_entity_id',
        //     '@oparam_err_flag',
        //     '@oparam_err_step',
        //     '@oparam_err_msg'
        // ];

        // return $this->runProcedure($model, $procedure, $iparams, $oparams);
    }

    public function update($model)
    {
        // $procedure = 'sproc_prd_product_dml_upd';

        // $iparams = [
        //     ':iparam_product_entity_id',
        //     ':iparam_product_name',
        //     ':iparam_product_type_entity_id',
        //     ':iparam_unit_rate',
        //     ':iparam_active',
        //     ':iparam_facility_ids',
        //     ':iparam_session_id',
        //     ':iparam_user_id',
        //     ':iparam_screen_id',
        //     ':iparam_debug_sproc',
        //     ':iparam_audit_screen_visit',
        // ];

        // $oparams = [
        //     '@oparam_err_flag',
        //     '@oparam_err_step',
        //     '@oparam_err_msg'
        // ];

        // return $this->runProcedure($model, $procedure, $iparams, $oparams);
    }

    public function delete($model)
    {
        // $procedure = 'sproc_prd_product_dml_del';

        // $iparams = [
        //     ':iparam_product_entity_id',
        //     ':iparam_session_id',
        //     ':iparam_user_id',
        //     ':iparam_screen_id',
        //     ':iparam_debug_sproc',
        //     ':iparam_audit_screen_visit',
        // ];

        // $oparams = [
        //     '@oparam_err_flag',
        //     '@oparam_err_step',
        //     '@oparam_err_msg'
        // ];

        // return $this->runProcedure($model, $procedure, $iparams, $oparams);
    }
}
