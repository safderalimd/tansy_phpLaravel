<?php

namespace App\Http\Modules\thirdparty\sms\Models;

class SendSmsExamSchedule extends SendSmsModel
{
    // todo: fix duplication
    protected $screenId = '/cabinet/send-sms---exam-schedule';
    public static $staticScreenId = '/cabinet/send-sms---exam-schedule';

    public $smsAccountTypes;

    public $exam;

    public function setEeiAttribute($value)
    {
        $this->setAttribute('exam_entity_id', $value);
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

        $this->smsAccountTypes = $this->repository->getAccountTypeFilter();
        $this->exam = $this->repository->getExam();
    }

    public function rows()
    {
        if (!is_null($this->filter_entity_id) && !is_null($this->filter_type)) {
            return $this->repository->examSchedule($this);
        }

        return [];
    }

    public function setSmsBatchAttributes()
    {
        $this->setAttribute('sms_type_id', $this->examScheduleSmsTypeId());
        $this->setAttribute('sms_account_row_type', $this->filter_type);
        $this->setAttribute('sms_account_entity_id', $this->filter_entity_id);
        $this->setAttribute('exam_entity_id', $this->exam_entity_id);
    }

    public function examScheduleSmsTypeId()
    {
        $smsTypes = $this->repository->getSmsTypes();

        foreach ($smsTypes as $item) {
            $type = trim($item['sms_type']);
            if ($type == 'Exam Schedule') {
                return $item['sms_type_id'];
            }
        }

        return null;
    }
}
