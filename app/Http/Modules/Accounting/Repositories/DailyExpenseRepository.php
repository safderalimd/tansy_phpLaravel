<?php

namespace App\Http\Modules\Accounting\Repositories;

use App\Http\Repositories\Repository;

class DailyExpenseRepository extends Repository
{
    // view_act_lkp_expense_type
    // expense_type    varchar(128)
    // expense_type_id tinyint(3) UN


    // view_org_lkp_organization_supplier
    // organization_name   varchar(259)
    // organization_entity_id  bigint(12)
    // organization_type   varchar(128)


    // view_act_lkp_payment_type
    // payment_type_id tinyint(3) UN
    // payment_type    varchar(128)


    public function getModelById($id)
    {
        return $this->select(
            'SELECT
                product AS product_name,
                product_type,
                unit_rate,
                product_type_entity_id,
                product_entity_id,
                active
             FROM view_prd_lkp_product
             WHERE product_entity_id = :id
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
