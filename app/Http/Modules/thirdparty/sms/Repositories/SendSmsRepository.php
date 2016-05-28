<?php

namespace App\Http\Modules\thirdparty\sms\Repositories;

use App\Http\Repositories\Repository;

class SendSmsRepository extends Repository
{
    public function smsBalanceCount()
    {
        return $this->select(
            'SELECT * FROM view_sms_balance_count LIMIT 1;'
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

    public function getSmsAccountTypes()
    {
        return $this->select(
            'SELECT
                row_type,
                entity_id,
                drop_down_list_name,
                sequence_id,
                reporting_order
            FROM view_sms_lkp_account_type
            ORDER BY sequence_id, reporting_order ASC;'
        );
    }

    public function feeReminders($model)
    {
        $procedure = 'sproc_act_rcv_due_lst';

        $iparams = [
            ':iparam_filter_type',
            ':iparam_subject_entity_id',
            ':iparam_return_type',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg'
        ];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }

    public function examResults($model)
    {
        $procedure = 'sproc_sch_sms_exam_result';

        $iparams = [
            ':iparam_filter_type',
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
            '@oparam_err_msg'
        ];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }

    public function otherSmsResults($model)
    {
        $procedure = 'sproc_sch_student_list';

        $iparams = [
            ':iparam_filter_type',
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
            '@oparam_err_msg'
        ];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }

    public function storeBatchStatus($model)
    {
        $procedure = '';

        $iparams = [

        ];

        $oparams = [
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg'
        ];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }



    // set @iparam_send_datetime =  '2016-05-27';
    // set @iparam_provider_name =  'Text Local';
    // set @iparam_provider_batch_id =  '1001';
    // set @iparam_provider_batch_status =  'D';
    // set @iparam_provider_batch_credits =  34;
    // set @iparam_provider_batch_error =  '';
    // set @iparam_sms_type_id =  8; -- send drop down primary key
    // set @iparam_account_filter_row_type = 'All Students'; -- send row_type from drop down using view_sms_lkp_account_type
    // set @iparam_account_filter_entity_id = 0; -- send entity_id from drop down using view_sms_lkp_account_type
    // set @iparam_filter2_id =  76; -- third drop down id
    // set @iparam_total_sms_in_batch = 45;
    // set @iparam_success_count =  40;
    // set @iparam_failure_count =  5;
    // set @iparam_common_message_flag = 0 ; -- 0 false, 1 true
    // set @iparam_common_message =  '';
    // set @iparam_entityID_smsMobile_PrvStatus_details =   '122-8801933344-D,123-8801933355-F';
    // set @iparam_log_json_sms_sent =  '';
    // set @iparam_log_json_sms_received = '' ;
    // set @iparam_log_json_batch_sent =  '';
    // set @iparam_log_json_batch_received =  '';


    // set @iparm_ipaddress = '10.10.9.100';
    // set @iparam_session_id = 101;
    // set @iparam_user_id = -1;
    // set @iparam_screen_id = 2001;
    // set @iparam_debug_sproc = 1;
    // set @iparam_audit_screen_visit = 1;

    // call sproc_sms_batch_dml_ins
    // (@iparam_send_datetime
    // ,@iparam_provider_name
    // ,@iparam_provider_batch_id
    // ,@iparam_provider_batch_status
    // ,@iparam_provider_batch_credits
    // ,@iparam_provider_batch_error
    // ,@iparam_sms_type_id
    // ,@iparam_account_filter_row_type
    // ,@iparam_account_filter_entity_id
    // ,@iparam_filter2_id
    // ,@iparam_total_sms_in_batch
    // ,@iparam_success_count
    // ,@iparam_failure_count
    // ,@iparam_common_message_flag
    // ,@iparam_common_message
    // ,@iparam_entityID_smsMobile_PrvStatus_details
    // ,@iparam_log_json_sms_sent
    // ,@iparam_log_json_sms_received
    // ,@iparam_log_json_batch_sent
    // ,@iparam_log_json_batch_received

    // ,@iparam_session_id -- pass in session id that you got from login stored proc
    // ,@iparam_user_id -- pass in user id that you got from login stored proc
    // ,@iparam_screen_id -- pass in screen id that you got from menu data set that was retuned from login stored proc
    // ,@iparam_debug_sproc -- for now pass in 1
    // ,@iparam_audit_screen_visit -- for now pass in 1

    // ,@oparam_err_flag -- this is standard err flag for all stored procs, it is 1 when the stored proc fails
    // ,@oparam_err_step -- this will tell step number that the stored proc has failed
    // ,@oparam_err_msg); -- stored proc failed error message

    // select @op_err_flag, @oparam_err_step, @oparam_err_msg;

}
