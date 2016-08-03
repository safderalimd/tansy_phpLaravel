<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Repository;

class GridRepository extends Repository
{
    public function filterDropdownValues($sql)
    {
        return $this->select($sql);
    }

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

    public function getSchoolName()
    {
        return $this->select(
            'SELECT
                organization_name,
                work_phone,
                mobile_phone,
                email,
                address1,
                address2,
                city_area,
                postal_code,
                city_id,
                organization_type_id,
                organization_entity_id
            FROM view_org_organization_detail_owner
            LIMIT 1;'
        );
    }
}
