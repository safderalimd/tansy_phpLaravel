<?php

namespace App\Http\Modules\thirdparty\sms\Models;

class SendSmsFeeDue extends SendSmsModel
{
    // todo: fix duplication
    protected $screenId = '/cabinet/send-sms---fee-due';
    public static $staticScreenId = '/cabinet/send-sms---fee-due';

    public $smsAccountTypes;

    public function __construct($arguments = [])
    {
        parent::__construct($arguments);

        $this->smsBalanceCount = $this->smsBalanceCount();
        $this->smsAccountTypes = $this->repository->getAccountTypeFilter();
    }

    public function setAeiAttribute($value)
    {
        $this->setAttribute('subject_entity_id', $value);
    }

    public function setArtAttribute($value)
    {
        $this->setAttribute('filter_type', $value);
    }

    public function rows()
    {
        if (!is_null($this->subject_entity_id) && !is_null($this->filter_type)) {
            $this->setAttribute('return_type', 'SMS');
            return $this->repository->feeReminders($this);
        }

        return [];
    }

    public function setSmsBatchAttributes()
    {
        $this->setAttribute('sms_type_id', $this->feeReminderSmsTypeId());
        $this->setAttribute('sms_account_row_type', $this->filter_type);
        $this->setAttribute('sms_account_entity_id', $this->subject_entity_id);
        $this->setAttribute('exam_entity_id', null);
    }

    public function feeReminderSmsTypeId()
    {
        $smsTypes = $this->repository->getSmsTypes();

        foreach ($smsTypes as $item) {
            $type = trim($item['sms_type']);
            if ($type == 'Fee Reminder') {
                return $item['sms_type_id'];
            }
        }

        return null;
    }
}
