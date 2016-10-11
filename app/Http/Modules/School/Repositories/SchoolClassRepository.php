<?php

namespace App\Http\Modules\School\Repositories;

use App\Http\Repositories\Repository;

class SchoolClassRepository extends Repository
{
    public function detail($model, $id)
    {
        $model->setAttribute('class_entity_id', $id);

        $procedure = 'sproc_sch_class_detail';

        $iparams = [
            ':iparam_class_entity_id',
        ];

        $oparams = [];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function getAllSchoolClasses() {
        return $this->select(
            'SELECT
                class_entity_id,
                class_name,
                class_group,
                class_category
             FROM view_sch_class_grid
             ORDER BY class_name ASC;'
        );
    }

    public function insert($model)
    {
        $procedure = 'sproc_sch_class_dml_ins';

        $iparams = [
            '-iparam_class_name',
            ':iparam_class_group_entity_id',
            ':iparam_class_category_entity_id',
            '-iparam_reporting_order',
            ':iparam_facility_ids',
            ':iparam_class_teacher_entity_id',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_class_entity_id',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function update($model)
    {
        $procedure = 'sproc_sch_class_dml_upd';

        $iparams = [
            ':iparam_class_entity_id',
            '-iparam_class_name',
            ':iparam_class_group_entity_id',
            ':iparam_class_category_entity_id',
            '-iparam_reporting_order',
            ':iparam_facility_ids',
            ':iparam_active',
            ':iparam_class_teacher_entity_id',
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
        $procedure = 'sproc_sch_class_dml_del';

        $iparams = [
            ':iparam_class_entity_id',
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
