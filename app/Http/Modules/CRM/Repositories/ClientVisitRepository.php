<?php

namespace App\Http\Modules\CRM\Repositories;

use App\Http\Repositories\Repository;

class ClientVisitRepository extends Repository
{
    public function getModelById($id)
    {
        return $this->select(
            'SELECT
                campaign_name,
                organization_name,
                facility_name,
                facility_city_name,
                contact_first_name,
                contact_mobile_phone,
                agent_name,
                agent_mobile_phone,
                product_name,
                unit_type,
                expected_units,
                commited_price,
                visit_date,
                visit_type,
                next_visit_date,
                next_visit_type,
                client_status,
                notes,
                visit_id,
                client_status_id,
                organization_entity_id,
                facility_entity_id,
                contact_entity_id,
                campaign_entity_id,
                agent_entity_id
             FROM view_crm_client_visit_detail
             WHERE visit_id = :id
             LIMIT 1;', ['id' => $id]
        );
    }

    public function getClientVisits()
    {
        return $this->select(
            'SELECT
                campaign_name,
                entity_name,
                client_status,
                visit_date,
                visit_id
             FROM view_crm_client_visit_grid;'
        );
    }

    public function getOrganizations()
    {
        return $this->select(
            'SELECT
                organization_name,
                organization_entity_id
             FROM view_org_lkp_organization
             ORDER BY organization_name ASC;'
        );
    }

    public function getClientOrganizations()
    {
        return $this->select(
            'SELECT
                organization_name,
                organization_entity_id,
                organization_type
             FROM view_org_lkp_organization
             WHERE organization_type = :type
             ORDER BY organization_name ASC;', ['type' => 'Client']
        );
    }

    public function getAgentOrganizations()
    {
        return $this->select(
            'SELECT
                organization_name,
                organization_entity_id,
                organization_type
             FROM view_org_lkp_organization
             WHERE organization_type = :type
             ORDER BY organization_name ASC;', ['type' => 'Broker']
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

    public function getContacts()
    {
        return $this->select(
            'SELECT
                contact_name,
                facility_entity_id,
                organization_entity_id,
                contact_entity_id
             FROM view_org_lkp_organization_contact
             ORDER BY contact_name ASC;'
        );
    }

    public function getAgents()
    {
        return $this->select(
            'SELECT
                agent_name,
                individual_entity_id,
                mobile_phone,
                organization_entity_id
             FROM view_org_lkp_agent
             ORDER BY agent_name ASC;'
        );
    }

    public function getUnitTypes()
    {
        return $this->select(
            'SELECT
                unit_type_id,
                unit_type
             FROM view_crm_lkp_unit_type
             ORDER BY unit_type ASC;'
        );
    }

    public function getVisitType()
    {
        return $this->select(
            'SELECT
                visit_type_id,
                visit_type
             FROM view_crm_lkp_visit_type
             ORDER BY visit_type ASC;'
        );
    }

    public function getCampaigns()
    {
        return $this->select(
            'SELECT
                campaign_name,
                campaign_entity_id
             FROM view_org_lkp_campaign
             ORDER BY campaign_name ASC;'
        );
    }

    public function getStatuses()
    {
        return $this->select(
            'SELECT
                client_status,
                client_status_id
             FROM view_crm_lkp_client_status
             ORDER BY client_status ASC;'
        );
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
            ':iparam_expected_units',
            ':iparam_commited_price',
            ':iparam_visit_date',
            ':iparam_visit_type_id',
            ':iparam_next_visit_date',
            ':iparam_next_visit_type_id',
            ':iparam_client_status_id',
            ':iparam_notes',

            ':iparam_new_organization_flag',
            ':iparam_organization_name',
            ':iparam_organization_address1',
            ':iparam_organization_address2',
            ':iparam_organization_city_area',
            ':iparam_organization_city_id',
            ':iparam_organization_work_phone',
            ':iparam_organization_mobile_phone',

            ':iparam_new_facility_flag',
            ':iparam_facility_name',
            ':iparam_facility_type_id',
            ':iparam_facility_address1',
            ':iparam_facility_address2',
            ':iparam_facility_city_area',
            ':iparam_facility_city_id',
            ':iparam_facility_work_phone',
            ':iparam_facility_mobile_phone',

            ':iparam_new_organization_contact_flag',
            ':iparam_organization_contact_frist_name',
            ':iparam_organization_contact_last_name',
            ':iparam_organization_contact_email',
            ':iparam_organization_contact_work_phone',
            ':iparam_organization_contact_mobile_phone',

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
            ':iparam_visit_date',
            ':iparam_client_status_id',
            ':iparam_notes',
            ':iparam_next_visit_date',
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
