<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Repository;

class GridRepository extends Repository
{
    public function dynamicGrid($params, $model)
    {
        $procedure = $params->procedure();
        $iparams   = $params->iparams();
        $oparams   = $params->oparams();

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function gridFilters($model)
    {
        $procedure = 'sproc_sys_dynamic_grid_filters';

        $iparams = [
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
