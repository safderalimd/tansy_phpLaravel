<?php

namespace App\Http\Modules\Organization\Repositories;

use App\Http\Repositories\Repository;

class OrganizationRepository extends Repository
{
    public function detail($model, $id)
    {
        $model->setAttribute('organization_entity_id', $id);

        $procedure = 'sproc_org_organization_detail';

        $iparams = [
            ':iparam_organization_entity_id',
        ];

        $oparams = [];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function getOrganizations()
    {
        return $this->lookup('sproc_org_organization_grid');
    }

    public function getOrganizationTypes()
    {
        return $this->lookup('sproc_org_lkp_organization_type_for_org_screen');
    }

    public function insert($model)
    {
        $procedure = 'sproc_org_organization_dml_ins';

        $iparams = [
            '-iparam_organization_name',
            ':iparam_organization_type_id',
            '-iparam_work_phone',
            '-iparam_mobile_phone',
            '-iparam_email',
            '-iparam_address1',
            '-iparam_address2',
            '-iparam_city_area',
            ':iparam_city_id',
            '-iparam_postal_code',
            '-iparam_create_new_facility',
            '-iparam_facility_name',
            ':iparam_facility_type_id',
            '-iparam_facility_work_phone',
            '-iparam_facility_mobile_phone',
            '-iparam_facility_email',
            '-iparam_facility_address1',
            '-iparam_facility_address2',
            '-iparam_facility_city_area',
            ':iparam_facility_city_id',
            '-iparam_facility_postal_code',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_organization_entity_id',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function update($model)
    {
        $procedure = 'sproc_org_organization_dml_upd';

        $iparams = [
            ':iparam_organization_entity_id',
            '-iparam_organization_name',
            ':iparam_organization_type_id',
            ':iparam_active',
            '-iparam_work_phone',
            '-iparam_mobile_phone',
            '-iparam_email',
            '-iparam_address1',
            '-iparam_address2',
            '-iparam_city_area',
            ':iparam_city_id',
            '-iparam_postal_code',
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
        $procedure = 'sproc_org_organization_dml_del';

        $iparams = [
            ':iparam_organization_entity_id',
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
