<?php

namespace App\Http\Modules\thirdparty\sms\Models;

use App\Http\Models\Model;
use App\Http\Modules\thirdparty\sms\SmsSender;

class SendSmsModel extends Model
{
    protected $repositoryNamespace = 'App\Http\Modules\thirdparty\sms\Repositories\SendSmsRepository';

    public $smsBalanceCount;

    public function __construct($arguments = [])
    {
        parent::__construct($arguments);
    }

    public function smsCredentials()
    {
        $credentials = $this->repository->smsCredentials();
        return [
            'username' => isset($credentials[0]['sender_user_name']) ? $credentials[0]['sender_user_name'] : '',
            'hash'     => isset($credentials[0]['sender_hash']) ? $credentials[0]['sender_hash'] : '',
            'senderId' => isset($credentials[0]['sender_id']) ? $credentials[0]['sender_id'] : '',
        ];
    }

    public function smsBalanceCount()
    {
        // check if the balance is in the session first
        $balance = session()->get('smsBalance');
        if (!is_null($balance) && is_numeric($balance)) {
            return $balance;
        }

        // make an api call to get the balance
        $api = $this->smsCredentials();
        $sender = new SmsSender($api['username'], $api['hash'], $api['senderId']);
        $balance = $sender->getBalance();
        if (!is_numeric($balance)) {
            $balance = 0;
        }

        // store the balance in the session
        session()->put('smsBalance', $balance);

        return $balance;
    }

    public function storeBatchStatus($data)
    {
        $model = new static;

        $model->setAttribute('send_datetime', date('Y-m-d'));
        $model->setAttribute('provider_name', 'Text Local');

        // a unique batch id does not exist
        $model->setAttribute('provider_batch_id', null);

        // a batch status does not exist, only statuses for single messages
        $model->setAttribute('provider_batch_status', null);

        $model->setAttribute('provider_batch_credits', $data['creditsUsed']);

        // a batch error does not exist for the batch, only for single messages
        $model->setAttribute('provider_batch_error', null);

        // drop down primary key
        $model->setAttribute('sms_type_id', $this->sms_type_id);

        // row_type from account type drop down
        $model->setAttribute('account_filter_row_type', $this->sms_account_row_type);

        // entity_id from account type drop down
        $model->setAttribute('account_filter_entity_id', $this->sms_account_entity_id);

        // third drop down id
        $model->setAttribute('filter2_id', $this->exam_entity_id);

        // i calculate this from php
        $model->setAttribute('total_sms_in_batch', $data['totalSmsInBatch']);

        // i calculate this from php
        $model->setAttribute('success_count', $data['successCount']);

        // i calculate this from php
        $model->setAttribute('failure_count', $data['failureCount']);

        // 0 false, 1 true
        $model->setAttribute('common_message_flag', intval($data['useCommonMessage']));

        $model->setAttribute('common_message', $data['commonMessage']);

        $model->setAttribute('entityID_smsMobile_PrvStatus_details', $data['accountIds']);

        $model->setAttribute('log_json_sms_sent', $data['xmlSent']);
        $model->setAttribute('log_json_sms_received', $data['jsonReceived']);
        $model->setAttribute('log_json_batch_sent', null);
        $model->setAttribute('log_json_batch_received', null);

        $model->setAttribute('balance_count', $data['balanceCount']);

        return $model->repository->storeBatchStatus($model);
    }
}
