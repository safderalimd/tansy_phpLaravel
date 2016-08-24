<?php

namespace App\Http\Modules\School\Repositories;

use App\Http\Repositories\Repository;

class EventsRepository extends Repository
{
    public function eventTypes($model)
    {
        $procedure = 'sproc_sch_lkp_exam_grading_system';
        $data = $this->procedure($model, $procedure, [], []);
        return first_resultset($data);
    }

    public function getGrid($model)
    {
        $procedure = 'sproc_org_events_grid';

        $iparams = [
            '-iparam_start_date',
            '-iparam_end_date',
            ':iparam_default_facility_id',
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

    public function detail($model)
    {
        $procedure = 'sproc_org_event_detail';

        $iparams = [
            ':iparam_event_id',
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

    public function insert($model)
    {
        $procedure = 'sproc_org_event_dml_ins';

        $iparams = [
            ':iparam_event_type_id',
            '-iparam_event_name',
            '-iparam_start_date',
            '-iparam_end_date',
            '-iparam_description',
            ':iparam_default_facility_id',
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
        $procedure = 'sproc_org_event_dml_upd';

        $iparams = [
            ':iparam_event_id',
            ':iparam_event_type_id',
            '-iparam_event_name',
            '-iparam_start_date',
            '-iparam_end_date',
            '-iparam_description',
            ':iparam_default_facility_id',
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
        $procedure = 'sproc_sch_org_events_dml_del';

        $iparams = [
            ':iparam_grade_system_id',
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
