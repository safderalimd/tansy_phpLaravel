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
            return $this->examResults();
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

    public function storeBatchStatus()
    {
        $model = new static;

        $model->settAttribute('send_datetime', date('Y-m-d'));
        $model->settAttribute('provider_name', 'Text Local');

        // a unique batch id does not exist
        $model->settAttribute('provider_batch_id', null);

        // a batch status does not exist, only statuses for single messages
        $model->settAttribute('provider_batch_status', null);

        $model->settAttribute('provider_batch_credits', $batch->credits_used);

        // a batch error does not exist for the batch, only for single messages
        $model->settAttribute('provider_batch_error', null);

        // drop down primary key
        $model->settAttribute('sms_type_id', $batch->sms_type_id);

        // row_type from account type drop down
        $model->settAttribute('account_filter_row_type', $batch->account_filter_row_type);

        // entity_id from account type drop down
        $model->settAttribute('account_filter_entity_id', $batch->account_filter_entity_id);

        // third drop down id
        $model->settAttribute('filter2_id', $batch->filter2_id);

        // i calculate this from php
        $model->settAttribute('total_sms_in_batch', $batch->total_sms_in_batch);

        // i calculate this from php
        $model->settAttribute('success_count', $batch->success_count);

        // i calculate this from php
        $model->settAttribute('failure_count', $batch->failure_count);

        // 0 false, 1 true
        $model->settAttribute('common_message_flag', $batch->common_message_flag);

        $model->settAttribute('common_message', $batch->common_message);

        // '122-8801933344-D,123-8801933355-F';
        $model->settAttribute('entityID_smsMobile_PrvStatus_details', $batch->entityID_smsMobile_PrvStatus_details);

        $model->settAttribute('log_json_sms_sent', $batch->log_json_sms_sent);
         //  '';
        $model->settAttribute('log_json_sms_received', $batch->log_json_sms_received);
         // '' ;
        $model->settAttribute('log_json_batch_sent', $batch->log_json_batch_sent);
         //  '';
        $model->settAttribute('log_json_batch_received', $batch->log_json_batch_received);
         //  '';
    }
}
