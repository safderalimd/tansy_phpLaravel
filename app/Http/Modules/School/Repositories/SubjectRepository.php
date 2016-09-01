<?php

namespace App\Http\Modules\School\Repositories;

use App\Http\Repositories\Repository;

class SubjectRepository extends Repository
{
    public function getModelById($id)
    {
        return $this->select(
            'SELECT
                subject AS subject_name,
                subject_type_id,
                reporting_order,
                short_code AS subject_short_code,
                active,
                subject_entity_id
             FROM view_sch_subject_detail
             WHERE subject_entity_id = :id
             LIMIT 1;', ['id' => $id]
        );
    }

    public function getSubjects()
    {
        return $this->select(
            'SELECT
                subject,
                subject_type,
                reporting_order,
                subject_entity_id
             FROM view_sch_subject_grid
             ORDER BY reporting_order ASC;'
        );
    }

    public function insert($model)
    {
        $procedure = 'sproc_sch_subject_dml_ins';

        $iparams = [
            '-iparam_subject_name',
            '-iparam_subject_short_code',
            ':iparam_subject_type_id',
            '-iparam_reporting_order',
            ':iparam_facility_ids',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_subject_entity_id',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function update($model)
    {
        $procedure = 'sproc_sch_subject_dml_upd';

        $iparams = [
            ':iparam_subject_entity_id',
            '-iparam_subject_name',
            '-iparam_subject_short_code',
            ':iparam_subject_type_id',
            '-iparam_reporting_order',
            ':iparam_active',
            ':iparam_facility_ids',
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
        $procedure = 'sproc_sch_subject_dml_del';

        $iparams = [
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
}
