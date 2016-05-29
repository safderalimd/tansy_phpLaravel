<?php

namespace App\Http\Modules\thirdparty\sms\Models;

class SendSmsFeeDue extends SendSmsModel
{
    protected $screenId = 2004;

    public $smsAccountTypes;

    public function loadData()
    {
        $this->smsBalanceCount = $this->smsBalanceCount();
        $this->smsAccountTypes = $this->repository->getSmsAccountTypes();
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

}
