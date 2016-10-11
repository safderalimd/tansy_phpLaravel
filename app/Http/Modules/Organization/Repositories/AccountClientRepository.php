<?php

namespace App\Http\Modules\Organization\Repositories;

use App\Http\Repositories\Repository;

class AccountClientRepository extends Repository
{
    public function getClientsGrid()
    {
        return $this->lookup('sproc_org_account_client_grid');
    }

    public function detail($model, $id)
    {
        $model->setAttribute('account_entity_id', $id);

        $procedure = 'sproc_org_account_client_detail';

        $iparams = [
            ':iparam_account_entity_id',
        ];

        $oparams = [];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function insert($model)
    {
        $procedure = 'sproc_org_account_client_dml_ins';

        $iparams = [
            ':iparam_facility_ids',
            '-iparam_unique_key_id',
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
        $procedure = 'sproc_org_account_client_dml_upd';

        $iparams = [
            ':iparam_account_entity_id',
            ':iparam_facility_ids',
            ':iparam_active',
            '-iparam_unique_key_id',
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
        $procedure = 'sproc_org_account_client_dml_del';

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

