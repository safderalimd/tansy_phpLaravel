<?php

namespace App\Http\Modules\thirdparty\sms\Models;

use App\Http\Models\Model;
use Exception;

class SendSmsModel extends Model
{
    protected $repositoryNamespace = 'App\Http\Modules\thirdparty\sms\Repositories\SendSmsRepository';

    public function __construct($arguments = [])
    {
        parent::__construct($arguments);
    }

    public function textlocalMessagePrefixes()
    {
        return $this->repository->textlocalMessagePrefixes();
    }

    public function credentials()
    {
        return $this->repository->credentials($this);
    }


    // public function storeBatchStatusV2($data)
    // {
    //     return $this->storeBatchStatus($data, true);
    // }

    // public function storeBatchStatus($data, $useV2 = false)
    // {
    //     $model = new static;

    //     if (isset($data['screen_id'])) {
    //         $model->setAttribute('screen_id', $data['screen_id']);
    //     }

    //     $model->setAttribute('send_datetime', date('Y-m-d'));
    //     $model->setAttribute('provider_name', 'Text Local');

    //     // a unique batch id does not exist
    //     $model->setAttribute('provider_batch_id', null);

    //     // a batch status does not exist, only statuses for single messages
    //     $model->setAttribute('provider_batch_status', null);

    //     $model->setAttribute('provider_batch_credits', $data['creditsUsed']);

    //     // a batch error does not exist for the batch, only for single messages
    //     $model->setAttribute('provider_batch_error', null);

    //     // drop down primary key
    //     $model->setAttribute('sms_type_id', $this->sms_type_id);

    //     // row_type from account type drop down
    //     $model->setAttribute('account_filter_row_type', $this->sms_account_row_type);

    //     // entity_id from account type drop down
    //     $model->setAttribute('account_filter_entity_id', $this->sms_account_entity_id);

    //     // third drop down id
    //     $model->setAttribute('filter2_id', $this->exam_entity_id);

    //     // i calculate this from php
    //     $model->setAttribute('total_sms_in_batch', $data['totalSmsInBatch']);

    //     // i calculate this from php
    //     $model->setAttribute('success_count', $data['successCount']);

    //     // i calculate this from php
    //     $model->setAttribute('failure_count', $data['failureCount']);

    //     // 0 false, 1 true
    //     $model->setAttribute('common_message_flag', intval($data['useCommonMessage']));

    //     $model->setAttribute('common_message', $data['commonMessage']);

    //     $model->setAttribute('entityID_smsMobile_PrvStatus_details', $data['accountIds']);

    //     $model->setAttribute('log_json_sms_sent', $data['xmlSent']);
    //     $model->setAttribute('log_json_sms_received', $data['jsonReceived']);
    //     $model->setAttribute('log_json_batch_sent', null);
    //     $model->setAttribute('log_json_batch_received', null);

    //     $model->setAttribute('balance_count', $data['balanceCount']);

    //     if ($useV2) {
    //         return $model->repository->storeBatchStatusV2($model);
    //     } else {
    //         return $model->repository->storeBatchStatus($model);
    //     }
    // }

    public function logSMS_V1()
    {
        return $this->repository->logSMS_V1($this);
    }

    public function setSmsTypeIdChangePassword()
    {
        $this->setAttribute('sms_type_id', $this->smsTypeIdFor('Change Password'));
    }

    public function setSmsTypeIdLoginOTP()
    {
        $this->setAttribute('sms_type_id', $this->smsTypeIdFor('Login OTP'));
    }

    public function setSmsTypeIdLoginSMS()
    {
        $this->setAttribute('sms_type_id', $this->smsTypeIdFor('Login SMS'));
    }

    public function smsTypeIdFor($smsType)
    {
        $types = $this->repository->getSmsTypes();
        foreach ($types as $type) {
            if ($type['sms_type'] == $smsType) {
                return $type['sms_type_id'];
            }
        }

        return null;
    }
}
