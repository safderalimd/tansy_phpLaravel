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

    public function smsMessagePrefix()
    {
        return $this->select(
            'SELECT
                prefix_id,
                prefix_text
             FROM view_sms_lkp_template_prefix LIMIT 1;'
        );
    }

    public function smsCredentials()
    {
        return $this->select(
            'SELECT
                provider_entity_id,
                sender_user_name,
                sender_hash,
                sender_id,
                active
             FROM view_sms_lkp_credentials
             WHERE active = 1
             LIMIT 1;'
        );
    }

    public function getSmsTypes()
    {
        return $this->select(
            'SELECT
                sms_type,
                sms_type_id
            FROM view_sms_lkp_sms_type
            ORDER BY sms_type ASC;'
        );
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

    public function storeBatchStatus($model)
    {
        $procedure = 'sproc_sms_batch_dml_ins';

        $iparams = [
            '-iparam_send_datetime',
            '-iparam_provider_name',
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

    public function storeBatchStatusV2($model)
    {
        $procedure = 'sproc_sms_batch_dml_ins_v2';

        $iparams = [
            '-iparam_send_datetime',
            '-iparam_provider_name',
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
