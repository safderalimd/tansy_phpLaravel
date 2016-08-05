<?php

namespace App\Http\Modules\Accounting\Repositories;

use App\Http\Repositories\Repository;

class DailyExpenseRepository extends Repository
{
    public function getExpenseTypes()
    {
        return $this->select(
            'SELECT
                expense_type,
                expense_type_id
             FROM view_act_lkp_expense_type
             ORDER BY expense_type ASC;'
        );
    }

    public function getOrganizationSupplier()
    {
        return $this->select(
            'SELECT
                organization_name,
                organization_entity_id,
                organization_type
             FROM view_org_lkp_organization_supplier
             ORDER BY organization_name ASC;'
        );
    }

    public function getPaymentTypes()
    {
        return $this->select(
            'SELECT
                payment_type_id,
                payment_type
             FROM view_act_lkp_payment_type
             ORDER BY payment_type ASC;'
        );
    }

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
