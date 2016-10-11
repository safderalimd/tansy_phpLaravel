<?php

namespace App\Http\Modules\System\Repositories;

use App\Http\Repositories\Repository;

class ManageLookupsRepository extends Repository
{
    public function getLookups()
    {
        return $this->lookup('sproc_sys_lkp_lookups');
    }

    public function lookupGrid($model)
    {
        $procedure = 'sproc_sys_grid_manage_lookup';

        $iparams = [
            ':iparam_lookup_id',
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
        $procedure = 'sproc_sys_manage_lookup_dml_ins';

        $iparams = [
            ':iparam_lookup_id',
            '-iparam_description',
            ':iparam_active',
            ':iparam_reporting_order',
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
        $procedure = 'sproc_sys_manage_lookup_dml_upd';

        $iparams = [
            ':iparam_lookup_id',
            ':iparam_primary_key_id',
            '-iparam_description',
            ':iparam_active',
            ':iparam_reporting_order',
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
