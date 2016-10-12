<?php

namespace App\Http\Modules\reports\School\Repositories;

use App\Http\Repositories\Repository;
use App\Http\Models\Model;

class DICERepository extends Repository
{
    public function getDice($model)
    {
        $procedure = 'sproc_sch_pdf_dice';
       
        $iparams = [
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
}
