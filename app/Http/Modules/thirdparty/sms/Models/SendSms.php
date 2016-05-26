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
            return [];
        } else {
            return [];
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
}
