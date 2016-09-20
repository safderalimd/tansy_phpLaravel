<?php

namespace App\Http\Modules\thirdparty\sms\Models;

class SendSmsGeneralV2 extends SendSmsModel
{
    // todo: fix duplication
    protected $screenId = '/cabinet/send-sms-v2';
    public static $staticScreenId = '/cabinet/send-sms-v2';

    public $generalSmsTypes;

    public $smsAccountTypes;

    public function setStiAttribute($value)
    {
        $this->setAttribute('sms_type_id', $value);
    }

    public function setAeiAttribute($value)
    {
        $this->setAttribute('filter_entity_id', $value);
    }

    public function setArtAttribute($value)
    {
        $this->setAttribute('filter_type', $value);
    }

    public function __construct($arguments = [])
    {
        parent::__construct($arguments);

        $this->generalSmsTypes = $this->generalSmsTypes();
        $this->smsAccountTypes = $this->repository->getAccountTypeFilter();
    }

    public function rows()
    {
        if (is_null($this->sms_type_id) || !is_numeric($this->sms_type_id)) {
            return [];
        }

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

    public function setSmsBatchAttributes()
    {
        $this->setAttribute('sms_type_id', $this->sms_type_id);
        $this->setAttribute('sms_account_row_type', $this->filter_type);
        $this->setAttribute('sms_account_entity_id', $this->filter_entity_id);
        $this->setAttribute('exam_entity_id', null);
    }
}
