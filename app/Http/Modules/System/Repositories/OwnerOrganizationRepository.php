<?php

namespace App\Http\Modules\System\Repositories;

use App\Http\Repositories\Repository;

class OwnerOrganizationRepository extends Repository
{
    public function getModelById($id)
    {
        return $this->select(
           'SELECT
                organization_name,
                address1,
                address2,
                city_name,
                city_area,
                work_phone,
                mobile_phone,
                contact_first_name,
                contact_last_name,
                contact_email,
                contact_work_phone,
                contact_mobile_phone,
                organization_entity_id,
                city_id
            FROM view_org_my_org_detail_02_org_detail
            LIMIT 1;'
        );
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
