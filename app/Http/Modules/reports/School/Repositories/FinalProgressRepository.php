<?php

namespace App\Http\Modules\reports\School\Repositories;

use App\Http\Repositories\Repository;

class FinalProgressRepository extends Repository
{
    public function generateProgressFinal($model)
    {
        $procedure = 'sproc_sch_generate_progress_final';

        $iparams = [
            '-iparam_filter_type',
            ':iparam_subject_entity_id',
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
}
