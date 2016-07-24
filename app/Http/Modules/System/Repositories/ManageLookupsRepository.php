<?php

namespace App\Http\Modules\System\Repositories;

use App\Http\Repositories\Repository;

class ManageLookupsRepository extends Repository
{
    public function getLookups()
    {
        return $this->select(
            'SELECT
                lookup_name,
                lookup_id
             FROM view_sys_lkp_lookups
             ORDER BY lookup_name ASC;'
        );
    }

    public function grid($model)
    {
        $procedure = 'sproc_hlp_html_help';

        $iparams = [
            '-iparam_filter_type',
            ':iparam_filter_id',
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
