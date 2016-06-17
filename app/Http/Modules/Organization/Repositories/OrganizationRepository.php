<?php

namespace App\Http\Modules\Organization\Repositories;

use App\Http\Repositories\Repository;

class OrganizationRepository extends Repository
{
    public function getModelById($id)
    {
        return $this->select(
            'SELECT
                organization_name,
                active,
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
            FROM view_org_organization_detail
            WHERE organization_entity_id = :id
            LIMIT 1;', ['id' => $id]
        );
    }

    public function getFacilityTypes()
    {
        return $this->select(
            'SELECT
                facility_type_id,
                facility_type
             FROM view_org_lkp_facility_type
             ORDER BY facility_type ASC;'
        );
    }

    public function getOrganizations()
    {
        return $this->select(
            'SELECT
                organization_name,
                organization_type,
                mobile_phone,
                active,
                organization_entity_id
             FROM view_org_organization_grid
             ORDER BY organization_name ASC;'
        );
    }

    public function getOrganizationTypes()
    {
        return $this->select(
            'SELECT
                organization_type,
                organization_type_id
             FROM view_org_lkp_organization_type_for_org_screen
             ORDER BY organization_type ASC;'
        );
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
