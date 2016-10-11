<?php

namespace App\Http\Modules\System\Repositories;

use App\Http\Repositories\Repository;

class OwnerOrganizationRepository extends Repository
{
    public function detail($model, $id)
    {
        $data = $this->lookup('sproc_org_my_org_detail_02_org_detail');
        return [$data];
    }

    public function update($model)
    {
        $procedure = 'sproc_org_my_org_dml_upd';

        $iparams = [
            ':iparam_organization_entity_id',
            '-iparam_organization_name',
            '-iparam_address1',
            '-iparam_address2',
            ':iparam_city_id',
            '-iparam_city_area',
            '-iparam_work_phone',
            '-iparam_mobile_phone',
            '-iparam_contact_first_name',
            '-iparam_contact_last_name',
            '-iparam_contact_email',
            '-iparam_contact_work_phone',
            '-iparam_contact_mobile_phone',
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
