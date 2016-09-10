<?php

namespace App\Http\Modules\reports\School\Repositories;

use App\Http\Repositories\Repository;

class HallTicketRepository extends Repository
{
    public function tickets($model)
    {
        $procedure = 'sproc_sch_exam_hall_ticket';

        $iparams = [
            ':iparam_filter_entity_id',
            ':iparam_exam_entity_id',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_show_image_in_hall_ticket',
            '@oparam_fiscal_year',
            '@oparam_school_name',
            '@oparam_school_city',
            '@oparam_school_phone',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }
}
