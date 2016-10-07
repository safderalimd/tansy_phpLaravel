<?php

namespace App\Http\Modules\Teacher\Repositories;

use App\Http\Repositories\Repository;

class TeacherQuickUpdateRepository extends Repository
{
    // public function dropdownOptions($sql)
    // {
    //     if (empty($sql)) {
    //         return [];
    //     }

    //     $options = [];
    //     foreach ($this->select($sql) as $row) {
    //         $option = [];
    //         foreach ($row as $key => $value) {
    //             if (is_numeric($key)) {
    //                 continue;
    //             }
    //             if (strpos($key, '_id') !== false) {
    //                 $option['id'] = $value;
    //             } else {
    //                 $option['name'] = $value;
    //             }
    //         }
    //         $options[] = $option;
    //     }

    //     return $options;
    // }

    public function getDepartment2()
    {
        // department_id, department_name
        return $this->lookup('sproc_org_lkp_department2');
    }

    public function grid($model)
    {
        $procedure = 'sproc_sch_teacher_multiple_update_grid';

        $iparams = [
            ':iparam_department_id',
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

    public function update($model)
    {
        $procedure = 'sproc_org_account_multiple_update_dml';

        $iparams = [
            ':iparam_field_id',
            '-iparam_accountEntityID_value',
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

