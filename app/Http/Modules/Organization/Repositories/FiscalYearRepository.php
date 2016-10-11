<?php

namespace App\Http\Modules\Organization\Repositories;

use App\Http\Repositories\Repository;

class FiscalYearRepository extends Repository
{
    public function getAllFiscalYears()
    {
        return $this->lookup('sproc_org_fiscal_year_grid');
    }

    public function detail($model, $id)
    {
        $model->setAttribute('fiscal_year_entity_id', $id);

        $procedure = 'sproc_org_fiscal_year_detail';

        $iparams = [
            ':iparam_fiscal_year_entity_id',
        ];

        $oparams = [];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function insert($model)
    {
        $procedure = 'sproc_org_fiscal_year_dml_ins';

        $iparams = [
            '-iparam_start_date',
            '-iparam_end_date',
            '-iparam_fiscal_year',
            '-iparam_current_fiscal_year',
            ':iparam_facility_ids',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_fiscal_year_entity_id',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function update($model)
    {
        $procedure = 'sproc_org_fiscal_year_dml_upd';

        $iparams = [
            '-iparam_start_date',
            '-iparam_end_date',
            '-iparam_fiscal_year',
            '-iparam_current_fiscal_year',
            '-iparam_facility_ids',
            ':iparam_fiscal_year_entity_id',
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
        $procedure = 'sproc_org_fiscal_year_dml_del';

        $iparams = [
            ':iparam_fiscal_year_entity_id',
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
