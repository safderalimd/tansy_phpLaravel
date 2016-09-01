<?php

namespace App\Http\Modules\Accounting\Repositories;

use App\Http\Repositories\Repository;

class DailyExpenseRepository extends Repository
{
    public function getModelById($id)
    {
        return $this->select(
            'SELECT
                expense_id,
                facility_entity_id,
                expense_type_id,
                supplier_organization_entity_id,
                expense_date,
                payment_type_id,
                amount,
                notes
             FROM view_act_exp_daily_expense
             WHERE expense_id = :id
             LIMIT 1;', ['id' => $id]
        );
    }

    public function insert($model)
    {
        $procedure = 'sproc_act_exp_daily_expense_dml_ins';

        $iparams = [
            ':iparam_expense_type_id',
            ':iparam_supplier_organization_entity_id',
            '-iparam_expense_date',
            ':iparam_payment_type_id',
            '+iparam_amount',
            '-iparam_notes',
            ':iparam_default_facility_id',
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
        $procedure = 'sproc_act_exp_daily_expense_dml_upd';

        $iparams = [
            ':iparam_expense_id',
            ':iparam_expense_type_id',
            ':iparam_supplier_organization_entity_id',
            '-iparam_expense_date',
            ':iparam_payment_type_id',
            '+iparam_amount',
            '-iparam_notes',
            ':iparam_default_facility_id',
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
