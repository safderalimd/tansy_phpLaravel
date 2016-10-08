<?php

namespace App\Http\Modules\CRM\Repositories;

use App\Http\Repositories\Repository;

class ClientVisitRepository extends Repository
{
    public function detail($model, $id)
    {
        $model->setAttribute('visit_id', $id);

        $procedure = 'sproc_crm_client_visit_detail';

        $iparams = [
            ':iparam_visit_id',
        ];

        $oparams = [];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function getContacts()
    {
        return $this->lookup('sproc_org_lkp_organization_contact');
    }

    public function insert($model)
    {
        $procedure = 'sproc_crm_client_visit_dml_ins';

        $iparams = [
            ':iparam_organization_entity_id',
            ':iparam_facility_entity_id',
            ':iparam_contact_entity_id',
            ':iparam_campaign_entity_id',
            ':iparam_agent_entity_id',
            ':iparam_product_entity_id',
            ':iparam_unit_type_id',
            '-iparam_expected_units',
            '-iparam_commited_price',
            '-iparam_visit_date',
            ':iparam_visit_type_id',
            '-iparam_next_visit_date',
            ':iparam_next_visit_type_id',
            ':iparam_client_status_id',
            '-iparam_notes',

            ':iparam_new_organization_flag',
            '-iparam_organization_name',
            '-iparam_organization_address1',
            '-iparam_organization_address2',
            '-iparam_organization_city_area',
            ':iparam_organization_city_id',
            '-iparam_organization_work_phone',
            '-iparam_organization_mobile_phone',

            ':iparam_new_facility_flag',
            '-iparam_facility_name',
            ':iparam_facility_type_id',
            '-iparam_facility_address1',
            '-iparam_facility_address2',
            '-iparam_facility_city_area',
            ':iparam_facility_city_id',
            '-iparam_facility_work_phone',
            '-iparam_facility_mobile_phone',

            ':iparam_new_organization_contact_flag',
            '-iparam_organization_contact_frist_name',
            '-iparam_organization_contact_last_name',
            '-iparam_organization_contact_email',
            '-iparam_organization_contact_work_phone',
            '-iparam_organization_contact_mobile_phone',

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
        $procedure = 'sproc_crm_client_visit_dml_upd';

        $iparams = [
            ':iparam_visit_id',
            ':iparam_organization_entity_id',
            ':iparam_facility_entity_id',
            ':iparam_agent_entity_id',
            '-iparam_visit_date',
            ':iparam_client_status_id',
            '-iparam_notes',
            '-iparam_next_visit_date',
            ':iparam_contact_entity_id',
            ':iparam_campaign_entity_id',
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
        $procedure = 'sproc_crm_client_visit_dml_del';

        $iparams = [
            ':iparam_visit_id',
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
