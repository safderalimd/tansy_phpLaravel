<?php

namespace App\Http\Modules\Parent\Repositories;

use App\Http\Repositories\Repository;

class MyExamScheduleRepository extends Repository
{
    public function grid($model)
    {
        $procedure = 'sproc_sch_parent_exam_schedule_grid';

        $iparams = [
            ':iparam_page_number',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_lazy_load_batch_size',
            '@oparam_show_lazy_load_search',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }
}
