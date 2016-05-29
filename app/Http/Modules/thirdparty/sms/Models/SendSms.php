<?php

namespace App\Http\Modules\thirdparty\sms\Models;

use App\Http\Models\Model;

class SendSms extends Model
{
    protected $screenId = 2004;

    protected $repositoryNamespace = 'App\Http\Modules\thirdparty\sms\Repositories\SendSmsRepository';

    public $smsTypes;

    public $smsAccountTypes;

    public $exam;

    public $selectedSmsType;

    public function setRequestAttributes($request)
    {
        $this->setAttribute('sms_type_id', $request->input('sti'));
        $this->setAttribute('sms_account_entity_id', $request->input('aei'));
        $this->setAttribute('sms_account_row_type', $request->input('art'));
        $this->setAttribute('exam_entity_id', $request->input('eei'));
    }

    public function loadData()
    {
        $this->smsBalanceCount = $this->smsBalanceCount();
        $this->smsTypes = $this->smsTypes();
        $this->smsAccountTypes = $this->smsAccountTypes();
        $this->exam = $this->exam();
    }

    public function rows()
    {
        if (!$this->issetSmsTypeId()) {
            return [];
        }

        $this->setSelectedSmsType();

        if ($this->smsIsOfType('Fee Reminder')) {
            return $this->feeReminders();
        } elseif ($this->smsIsOfType('Exam Result')) {
            if (!empty($this->exam_entity_id)) {
                return $this->examResults();
            } else {
                return [];
            }
        } else {
            return $this->otherSmsResults();
        }

        return [];
    }

    public function feeReminders()
    {
        if (!is_null($this->sms_account_row_type) && !is_null($this->sms_account_entity_id)) {
            $this->setAttribute('filter_type', $this->sms_account_row_type);
            $this->setAttribute('subject_entity_id', $this->sms_account_entity_id);
            $this->setAttribute('return_type', 'SMS');
            return $this->repository->feeReminders($this);
        }

        return [];
    }

    public function examResults()
    {
        if (!is_null($this->sms_account_row_type) && !is_null($this->sms_account_entity_id)) {
            $this->setAttribute('filter_type', $this->sms_account_row_type);
            $this->setAttribute('filter_entity_id', $this->sms_account_entity_id);
            $this->setAttribute('exam_entity_id', $this->exam_entity_id);
            return $this->repository->examResults($this);
        }

        return [];
    }

    public function otherSmsResults()
    {
        if (!is_null($this->sms_account_row_type) && !is_null($this->sms_account_entity_id)) {
            $this->setAttribute('filter_type', $this->sms_account_row_type);
            $this->setAttribute('filter_entity_id', $this->sms_account_entity_id);
            return $this->repository->otherSmsResults($this);
        }

        return [];
    }

    public function smsIsOfType($type)
    {
        $type = $this->normalize($type);

        if ($type == $this->selectedSmsType) {
            return true;
        }

        return false;
    }

    public function issetSmsTypeId()
    {
        if (empty($this->sms_type_id)) {
            return false;
        }

        return true;
    }

    public function setSelectedSmsType()
    {
        $selectedSmsType = null;
        foreach ($this->smsTypes as $type) {
            if ($type['sms_type_id'] == $this->sms_type_id) {
                $selectedSmsType = $type['sms_type'];
                break;
            }
        }
        $this->selectedSmsType = $this->normalize($selectedSmsType);
    }

    public function normalize($string)
    {
        $string = trim($string);
        return strtolower($string);
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
