<?php

namespace App\Http\Modules\reports\School\Repositories;

use App\Http\Repositories\Repository;

class FeeDueReportRepository extends Repository
{
    public function getAllFees($model)
    {
        $procedure = 'sproc_act_rcv_due_lst';

        $iparams = [
            '-iparam_filter_type',
            ':iparam_subject_entity_id',
            '-iparam_return_type',
            ':iparam_product_entity_id',
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

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }

    // Todo: filter this select
    public function getSchoolName()
    {
        return $this->select(
            'SELECT
                organization_name,
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
            FROM view_org_organization_detail_owner
            LIMIT 1;'
        );
    }

    public function getFilterCriteria($model)
    {
        $procedure = 'sproc_org_lkp_account_type_4_receivable_payment';

        $iparams = [
            ':iparam_primary_key_id'
        ];

        $oparams = [];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);

        // return $this->select(
        //     'SELECT
        //         row_type,
        //         primary_key_id,
        //         drop_down_list_name,
        //         sequence_id
        //     FROM view_org_lkp_account_type_4_receivable_payment
        //     WHERE primary_key_id = :id
        //     LIMIT 1;', ['id' => $id]
        // );
    }
}
