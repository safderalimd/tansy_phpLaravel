<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Repository;

class SecurityRepository extends Repository
{
    public function studentExists($model)
    {
        return $this->select(
           'SELECT
               count(*)
            FROM view_sch_lkp_student
            WHERE class_student_id = :csi
            AND student_entity_id = :sei
            LIMIT 1;', [
                'csi' => $model->class_student_id,
                'sei' => $model->student_entity_id
            ]
        );
    }

    public function checkPermission($model)
    {
        $procedure = 'sproc_sec_check_screen_permission';

        $iparams = [
            ':iparam_screen_id',
            ':iparam_user_id',
            ':iparam_student_entity_id',
        ];

        $oparams = [
            '@oparam_valid_access',
            '@oparam_valid_dashboard',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }
}
