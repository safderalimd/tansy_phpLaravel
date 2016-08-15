<?php

namespace App\Http\Modules\School\Repositories;

use App\Http\Repositories\Repository;

class ExamSetupRepository extends Repository
{
    // public function getExamTypes()
    // {
    //     return $this->select(
    //         'SELECT
    //             exam_type_id,
    //             exam_type
    //          FROM view_sch_lkp_exam_type;'
    //     );
    // }

    public function examDropdown($model)
    {
        $procedure = 'sproc_sch_lkp_main_exam';
        $iparams = [];
        $oparams = [];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }

    public function getExamSetupGrid($model)
    {
        $procedure = 'sproc_sch_exam_setup_grid';

        $iparams = [
            ':iparam_exam_entity_id',
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

    // public function detail($model)
    // {
    //     $procedure = 'sproc_sch_exam_detail';

    //     $iparams = [
    //         ':iparam_exam_entity_id',
    //         ':iparam_session_id',
    //         ':iparam_user_id',
    //         ':iparam_screen_id',
    //         ':iparam_debug_sproc',
    //         ':iparam_audit_screen_visit',
    //     ];

    //     $oparams = [
    //         '@oparam_attendance_jan',
    //         '@oparam_attendance_feb',
    //         '@oparam_attendance_mar',
    //         '@oparam_attendance_apr',
    //         '@oparam_attendance_may',
    //         '@oparam_attendance_jun',
    //         '@oparam_attendance_jul',
    //         '@oparam_attendance_aug',
    //         '@oparam_attendance_sep',
    //         '@oparam_attendance_oct',
    //         '@oparam_attendance_nov',
    //         '@oparam_attendance_dec',
    //         '@oparam_err_flag',
    //         '@oparam_err_step',
    //         '@oparam_err_msg',
    //     ];

    //     $data = $this->procedure($model, $procedure, $iparams, $oparams);
    //     return first_resultset($data);
    // }

    // public function insert($model)
    // {
    //     $procedure = 'sproc_sch_exam_dml_ins';

    //     $iparams = [
    //         '-iparam_exam_name',
    //         ':iparam_exam_type_id',
    //         '-iparam_reporting_order',
    //         '-iparam_progress_card_reporting_order',
    //         ':iparam_facility_ids',
    //         '-iparam_exam_short_code',
    //         ':iparam_attendance_jan',
    //         ':iparam_attendance_feb',
    //         ':iparam_attendance_mar',
    //         ':iparam_attendance_apr',
    //         ':iparam_attendance_may',
    //         ':iparam_attendance_jun',
    //         ':iparam_attendance_jul',
    //         ':iparam_attendance_aug',
    //         ':iparam_attendance_sep',
    //         ':iparam_attendance_oct',
    //         ':iparam_attendance_nov',
    //         ':iparam_attendance_dec',
    //         ':iparam_session_id',
    //         ':iparam_user_id',
    //         ':iparam_screen_id',
    //         ':iparam_debug_sproc',
    //         ':iparam_audit_screen_visit',
    //     ];

    //     $oparams = [
    //         '@oparam_exam_entity_id',
    //         '@oparam_err_flag',
    //         '@oparam_err_step',
    //         '@oparam_err_msg',
    //     ];

    //     return $this->procedure($model, $procedure, $iparams, $oparams);
    // }

    // public function update($model)
    // {
    //     $procedure = 'sproc_sch_exam_dml_upd';

    //     $iparams = [
    //         ':iparam_exam_entity_id',
    //         '-iparam_exam_name',
    //         ':iparam_exam_type_id',
    //         '-iparam_reporting_order',
    //         '-iparam_progress_card_reporting_order',
    //         ':iparam_active',
    //         ':iparam_facility_ids',
    //         '-iparam_exam_short_code',
    //         ':iparam_attendance_jan',
    //         ':iparam_attendance_feb',
    //         ':iparam_attendance_mar',
    //         ':iparam_attendance_apr',
    //         ':iparam_attendance_may',
    //         ':iparam_attendance_jun',
    //         ':iparam_attendance_jul',
    //         ':iparam_attendance_aug',
    //         ':iparam_attendance_sep',
    //         ':iparam_attendance_oct',
    //         ':iparam_attendance_nov',
    //         ':iparam_attendance_dec',
    //         ':iparam_session_id',
    //         ':iparam_user_id',
    //         ':iparam_screen_id',
    //         ':iparam_debug_sproc',
    //         ':iparam_audit_screen_visit',
    //     ];

    //     $oparams = [
    //         '@oparam_err_flag',
    //         '@oparam_err_step',
    //         '@oparam_err_msg',
    //     ];

    //     return $this->procedure($model, $procedure, $iparams, $oparams);
    // }

    // public function delete($model)
    // {
    //     $procedure = 'sproc_sch_exam_dml_del';

    //     $iparams = [
    //         ':iparam_exam_entity_id',
    //         ':iparam_session_id',
    //         ':iparam_user_id',
    //         ':iparam_screen_id',
    //         ':iparam_debug_sproc',
    //         ':iparam_audit_screen_visit',
    //     ];

    //     $oparams = [
    //         '@oparam_err_flag',
    //         '@oparam_err_step',
    //         '@oparam_err_msg',
    //     ];

    //     return $this->procedure($model, $procedure, $iparams, $oparams);
    // }
}
