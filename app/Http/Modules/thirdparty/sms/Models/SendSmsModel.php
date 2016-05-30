<?php

namespace App\Http\Modules\thirdparty\sms\Models;

use App\Http\Models\Model;

class SendSmsModel extends Model
{
    protected $repositoryNamespace = 'App\Http\Modules\thirdparty\sms\Repositories\SendSmsRepository';

    public $smsBalanceCount;

    public function __construct($arguments)
    {
        parent::__construct($arguments);
    }

    public function smsBalanceCount()
    {
        $count = $this->repository->smsBalanceCount();
        if (!is_array($count)) {
            return 0;
        }

        $count = array_shift($count);
        $count = array_values($count);
        if (isset($count[0])) {
            return $count[0];
        }

        return 0;
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

        return $model->repository->storeBatchStatus($model);
    }
}
