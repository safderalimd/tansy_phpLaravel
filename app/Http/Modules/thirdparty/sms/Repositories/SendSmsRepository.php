<?php

namespace App\Http\Modules\thirdparty\sms\Repositories;

use App\Http\Repositories\Repository;

class SendSmsRepository extends Repository
{
    public function examDropdown($model)
    {
        $procedure = 'sproc_sch_lkp_main_exam';
        $data = $this->procedure($model, $procedure, [], []);
        return first_resultset($data);
    }

    public function textlocalMessagePrefixes()
    {
        // prefix_id, prefix_text, prefix_type
        return $this->lookup('sproc_sms_lkp_template_prefix');
    }

    public function credentials($model)
    {
        $data = $this->procedure($model, 'sproc_sms_lkp_credentials', [], []);
        return first_resultset($data);
    }

    public function getSmsTypes()
    {
        // sms_type, sms_type_id
        return $this->lookup('sproc_sms_lkp_sms_type');
    }

    public function feeReminders($model)
    {
        $procedure = 'sproc_act_rcv_due_lst';

        $iparams = [
            '-iparam_filter_type',
            ':iparam_subject_entity_id',
            '-iparam_return_type',
            ':iparam_product_entity_id',
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

    public function examSchedule($model)
    {
        $procedure = 'sproc_sch_sms_exam_schedule';

        $iparams = [
            '-iparam_filter_type',
            ':iparam_filter_entity_id',
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

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }

    public function examResults($model)
    {
        $procedure = 'sproc_sch_sms_exam_result';

        $iparams = [
            '-iparam_filter_type',
            ':iparam_filter_entity_id',
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

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }

    public function getProgressList($model)
    {
        $procedure = 'sproc_sch_progress_lst';

        $iparams = [
            ':iparam_exam_entity_id',
            ':iparam_filter_entity_id',
            ':iparam_class_student_id',
            '-iparam_return_type',
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

    public function generalSmsResults($model)
    {
        $procedure = 'sproc_sms_send_list_for_generic_sms';

        $iparams = [
            '-iparam_filter_type',
            ':iparam_filter_entity_id',
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

    public function homeWork($model)
    {
        $procedure = 'sproc_sch_sms_home_work';

        $iparams = [
            ':iparam_filter_entity_id',
            '-iparam_home_work_date',
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

    public function absenteesSmsResults($model)
    {
        $procedure = 'sproc_sch_sms_attendance';

        $iparams = [
            '-iparam_filter_type',
            ':iparam_filter_entity_id',
            '-iparam_absense_date',
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

    public function logSMS_V1($model)
    {
        return $this->logSMS($model, 'sproc_sms_batch_dml_ins');
    }

    public function logSMS_V2($model)
    {
        return $this->logSMS($model, 'sproc_sms_batch_dml_ins_v2');
    }

    public function logSMS($model, $procedure)
    {
        $iparams = [
            ':iparam_provider_entity_id',
            ':iparam_route_type_id',
            '-iparam_provider_batch_id',
            '-iparam_provider_batch_status',
            '-iparam_provider_batch_credits',
            '-iparam_provider_batch_error',
            '-iparam_sms_type_id',
            '-iparam_account_filter_row_type',
            '-iparam_account_filter_entity_id',
            '-iparam_filter2_id',
            ':iparam_total_sms_in_batch',
            ':iparam_success_count',
            ':iparam_failure_count',
            ':iparam_common_message_flag',
            '-iparam_common_message',
            '-iparam_entityID_smsMobile_PrvStatus_details',
            '-iparam_log_json_sms_sent',
            '-iparam_log_json_sms_received',
            '-iparam_log_json_batch_sent',
            '-iparam_log_json_batch_received',

            ':iparam_balance_count',

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
