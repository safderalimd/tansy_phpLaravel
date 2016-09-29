<?php

namespace App\Http\Modules\Campaign\Repositories;

use App\Http\Repositories\Repository;

class LeadEntryRepository extends Repository
{
    public function insert($model)
    {
        $procedure = 'sproc_org_account_lead_mutli_dml_ins';

        $iparams = [
            ':iparam_city_id',
            '-iparam_firstName_lastName_mobilePhone_email',
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
