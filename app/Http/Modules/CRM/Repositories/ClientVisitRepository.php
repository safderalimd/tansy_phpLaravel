<?php

namespace App\Http\Modules\CRM\Repositories;

use App\Http\Repositories\Repository;

class ClientVisitRepository extends Repository
{
    public function getModelById($id)
    {
        return $this->select(
            'SELECT
                campaign_entity_id,
                organization_entity_id,
                facility_entity_id,
                contact_entity_id,
                agent_entity_id,
                visit_date,
                notes,
                next_visit_date,
                visit_id
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
                organization_type,
                mobile_phone,
                active,
                organization_entity_id
             FROM view_org_organization_grid
             ORDER BY organization_name ASC;'
        );
    }

    // public function insert($model)
    // {
    //     $procedure = 'sproc_prd_product_dml_ins';

    //     $iparams = [
    //         ':iparam_product_name',
    //         ':iparam_product_type_entity_id',
    //         ':iparam_unit_rate',
    //         ':iparam_facility_ids',
    //         ':iparam_session_id',
    //         ':iparam_user_id',
    //         ':iparam_screen_id',
    //         ':iparam_debug_sproc',
    //         ':iparam_audit_screen_visit',
    //     ];

    //     $oparams = [
    //         '@oparam_product_entity_id',
    //         '@oparam_err_flag',
    //         '@oparam_err_step',
    //         '@oparam_err_msg',
    //     ];

    //     return $this->runProcedure($model, $procedure, $iparams, $oparams);
    // }

    // public function update($model)
    // {
    //     $procedure = 'sproc_prd_product_dml_upd';

    //     $iparams = [
    //         ':iparam_product_entity_id',
    //         ':iparam_product_name',
    //         ':iparam_product_type_entity_id',
    //         ':iparam_unit_rate',
    //         ':iparam_active',
    //         ':iparam_facility_ids',
    //         ':iparam_session_id',
    //         ':iparam_user_id',
    //         ':iparam_screen_id',
    //         ':iparam_debug_sproc',
    //         ':iparam_audit_screen_visit',
    //     ];

    //     $oparams = [
    //         '@oparam_err_flag',
    //         '@oparam_err_step',
    //         '@oparam_err_msg',
    //     ];

    //     return $this->runProcedure($model, $procedure, $iparams, $oparams);
    // }

    // public function delete($model)
    // {
    //     $procedure = 'sproc_prd_product_dml_del';

    //     $iparams = [
    //         ':iparam_product_entity_id',
    //         ':iparam_session_id',
    //         ':iparam_user_id',
    //         ':iparam_screen_id',
    //         ':iparam_debug_sproc',
    //         ':iparam_audit_screen_visit',
    //     ];

    //     $oparams = [
    //         '@oparam_err_flag',
    //         '@oparam_err_step',
    //         '@oparam_err_msg',
    //     ];

    //     return $this->runProcedure($model, $procedure, $iparams, $oparams);
    // }
}
