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
                password AS field_password,
                login_user_account_status AS user_account_active,
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
            ':iparam_first_name',
            ':iparam_middle_name',
            ':iparam_last_name',
            ':iparam_date_of_birth',
            ':iparam_gender',
            ':iparam_email',
            ':iparam_work_phone',
            ':iparam_mobile_phone',
            ':iparam_address1',
            ':iparam_address2',
            ':iparam_city_area',
            ':iparam_city_id',
            ':iparam_postal_code',
            ':iparam_login_name',
            ':iparam_password',
            ':iparam_user_account_active',
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
            ':iparam_first_name',
            ':iparam_middle_name',
            ':iparam_last_name',
            ':iparam_date_of_birth',
            ':iparam_gender',
            ':iparam_email',
            ':iparam_work_phone',
            ':iparam_mobile_phone',
            ':iparam_address1',
            ':iparam_address2',
            ':iparam_city_area',
            ':iparam_city_id',
            ':iparam_postal_code',
            ':iparam_login_name',
            ':iparam_password',
            ':iparam_user_account_active',
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

