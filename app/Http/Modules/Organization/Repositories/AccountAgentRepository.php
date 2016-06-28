<?php

namespace App\Http\Modules\Organization\Repositories;

use App\Http\Repositories\Repository;

class AccountAgentRepository extends Repository
{
    public function getAgents()
    {
        return $this->select(
            'SELECT
                account_name,
                company_name,
                city_name,
                mobile_phone,
                account_entity_id
             FROM view_org_account_agent_grid
             ORDER BY account_name ASC;'
        );
    }

    public function getSecurityGroupForAgent()
    {
        return $this->select(
            'SELECT
                security_group,
                security_group_entity_id,
                system_value
             FROM view_sec_lkp_security_group
             WHERE security_group = :group
             LIMIT 1;', ['group' => 'Agent']
        );
    }

    public function getOrganizationsForBrokers()
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

    public function getModelById($id)
    {
        return $this->select(
            'SELECT
                active,
                first_name,
                middle_name,
                last_name,
                date_of_birth,
                gender,
                email,
                work_phone,
                mobile_phone,
                address1,
                address2,
                city_id,
                city_area,
                postal_code,
                login_name,
                password,
                login_active,
                default_facility_id AS view_default_facility_id,
                group_entity_id AS security_group_entity_id,
                document_type_id,
                document_number,
                account_entity_id
            FROM view_org_account_agent_detail
            WHERE account_entity_id = :id
            LIMIT 1;', ['id' => $id]
        );
    }

    public function insert($model)
    {
        $procedure = 'sproc_org_account_agent_dml_ins';

        $iparams = [
            ':iparam_facility_ids',
            ':iparam_organization_entity_id',
            ':iparam_active',
            '-iparam_first_name',
            '-iparam_middle_name',
            '-iparam_last_name',
            '-iparam_date_of_birth',
            '-iparam_gender',
            '-iparam_email',
            '-iparam_work_phone',
            '-iparam_mobile_phone',
            '-iparam_address1',
            '-iparam_address2',
            '-iparam_city_area',
            ':iparam_city_id',
            '-iparam_postal_code',
            ':iparam_document_type_id',
            '-iparam_document_number',
            '-iparam_login_name',
            '-iparam_password',
            ':iparam_login_active',
            ':iparam_view_default_facility_id',
            ':iparam_security_group_entity_id',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_account_entity_id',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function update($model)
    {
        $procedure = 'sproc_org_account_agent_dml_upd';

        $iparams = [
            ':iparam_account_entity_id',
            ':iparam_facility_ids',
            ':iparam_organization_entity_id',
            ':iparam_active',
            '-iparam_first_name',
            '-iparam_middle_name',
            '-iparam_last_name',
            '-iparam_date_of_birth',
            '-iparam_gender',
            '-iparam_email',
            '-iparam_work_phone',
            '-iparam_mobile_phone',
            '-iparam_address1',
            '-iparam_address2',
            '-iparam_city_area',
            ':iparam_city_id',
            '-iparam_postal_code',
            ':iparam_document_type_id',
            '-iparam_document_number',
            '-iparam_login_name',
            '-iparam_password',
            ':iparam_login_active',
            ':iparam_view_default_facility_id',
            ':iparam_security_group_entity_id',
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
        $procedure = 'sproc_org_account_agent_dml_del';

        $iparams = [
            ':iparam_account_entity_id',
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

