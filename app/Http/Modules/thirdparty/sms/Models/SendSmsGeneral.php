<?php

namespace App\Http\Modules\thirdparty\sms\Models;

class SendSmsGeneral extends SendSmsModel
{
    protected $screenId = 2007;

    public $generalSmsTypes;

    public $smsAccountTypes;

    public function setAeiAttribute($value)
    {
        $this->setAttribute('filter_entity_id', $value);
    }

    public function setArtAttribute($value)
    {
        $this->setAttribute('filter_type', $value);
    }

    public function loadData()
    {
        $this->generalSmsTypes = $this->generalSmsTypes();
        $this->smsBalanceCount = $this->smsBalanceCount();
        $this->smsAccountTypes = $this->repository->getSmsAccountTypes();
    }

    public function rows()
    {
        if (!is_null($this->filter_entity_id) && !is_null($this->filter_type)) {
            return $this->repository->generalSmsResults($this);
        }

        return [];
    }

    public function generalSmsTypes()
    {
        $allTypes = $this->repository->getSmsTypes();

        $filters = ['Fee Reminder', 'Exam Result', 'Absentees'];
        return array_filter($allTypes, function($item) use ($filters) {
            $type = trim($item['sms_type']);
            return (in_array($type, $filters)) ? false : true;
        });
    }
}
