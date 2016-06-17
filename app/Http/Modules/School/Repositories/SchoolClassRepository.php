<?php

namespace App\Http\Modules\School\Repositories;

use App\Http\Repositories\Repository;

class SchoolClassRepository extends Repository
{
    public function getModelById($id)
    {
        return $this->select(
            'SELECT
                class_entity_id,
                class_name,
                description,
                reporting_order,
                class_category_entity_id,
                class_group_entity_id,
                facility_entity_id AS facility_ids,
                active,
                class_teacher_entity_id
             FROM view_sch_class_detail
             WHERE class_entity_id = :id
             LIMIT 1;', ['id' => $id]
        );
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

    public function getClassGroups()
    {
        return $this->select(
            'SELECT
                class_group_entity_id,
                class_group
             FROM view_sch_lkp_class_group
             ORDER BY class_group ASC;'
        );
    }

    public function getClassCategories()
    {
        return $this->select(
            'SELECT
                class_category_entity_id,
                class_category
             FROM view_sch_lkp_class_category
             ORDER BY class_category ASC;'
        );
    }

    public function getFacilities()
    {
        return $this->select(
            'SELECT
                facility_entity_id,
                facility_name
             FROM view_org_facility_lkp
             ORDER BY facility_name ASC;'
        );
    }

    public function getTeachers()
    {
        return $this->select(
            'SELECT
                employee_entity_id,
                employee_name
             FROM view_org_lkp_account_employee
             ORDER BY employee_name ASC;'
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
