<?php

namespace App\Http\Modules\Teacher\Repositories;

use App\Http\Repositories\Repository;

class ClassTimeTableRepository extends Repository
{
    public function classSubject($model)
    {
        // subject, subject_entity_id
        $procedure = 'sproc_sch_lkp_class_subjects';

        $iparams = [
            ':iparam_class_entity_id',
        ];

        $oparams = [];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function classSubjectTeacher($model)
    {
        $procedure = 'sproc_sch_lkp_class_subject_teacher';

        $iparams = [
            ':iparam_class_entity_id',
            ':iparam_subject_entity_id',
            ':iparam_teacher_entity_id',
        ];

        $oparams = [];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function detail($model)
    {
        $procedure = 'sproc_sch_time_table_detail';

        $iparams = [
            ':iparam_account_entity_id',
            '-iparam_start_date',
            '-iparam_end_date',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_entity_type',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function teachersDetail($model)
    {
        $procedure = 'sproc_sch_time_table_detail';

        $iparams = [
            ':iparam_teacher_account_entity_id',
            '-iparam_start_date',
            '-iparam_teacher_end_date',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_entity_type',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        return $this->procedure($model, $procedure, $iparams, $oparams);
    }

    public function update($model)
    {
        $procedure = 'sproc_sch_time_table_dml_upd';

        $iparams = [
            ':iparam_class_entity_id',
            '-iparam_effective_start_date',
            '-iparam_effective_end_date',
            '-iparam_weekID_periodID_subjectID',
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
