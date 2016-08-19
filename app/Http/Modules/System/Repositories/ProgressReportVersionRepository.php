<?php

namespace App\Http\Modules\System\Repositories;

use App\Http\Repositories\Repository;

class ProgressReportVersionRepository extends Repository
{
    public function examDropdown($model)
    {
        $procedure = 'sproc_sch_lkp_main_exam';
        $data = $this->procedure($model, $procedure, [], []);
        return first_resultset($data);
    }

    public function reportType($model)
    {
        $procedure = 'sproc_sch_lkp_exam_report_type';
        $data = $this->procedure($model, $procedure, [], []);
        return first_resultset($data);
    }

    public function reportVersion($model)
    {
        $procedure = 'sproc_sch_lkp_exam_report_version';

        $iparams = [
            '-iparam_report_type'
        ];

        $data = $this->procedure($model, $procedure, $iparams, []);
        return first_resultset($data);
    }

    public function getGrid($model)
    {
        $procedure = 'sproc_sch_exam_report_version_grid';

        $iparams = [
            ':iparam_exam_entity_id',
            '-iparam_report_type',
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

    public function update($model)
    {
        $procedure = 'sproc_sch_exam_progress_report_version_ins';

        $iparams = [
            ':iparam_exam_entity_id',
            '-iparam_report_type',
            ':iparam_report_version_id',
            '-iparam_classIDS',
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
