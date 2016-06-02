<?php

namespace App\Http\Modules\Admin\Repositories;

use App\Http\Repositories\Repository;

class AdminRepository extends Repository
{
    public function homeData($model)
    {
        $procedure = 'sproc_org_home_sysadmin_v1';

        $iparams = [
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_employee_absentee',
            '@oparam_sms_send_count',
            '@oparam_collection_amount',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function dueList($model)
    {
        $procedure = 'sproc_act_rcv_due_lst';

        $iparams = [
            ':iparam_filter_type',
            ':iparam_subject_entity_id',
            ':iparam_return_type',
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
