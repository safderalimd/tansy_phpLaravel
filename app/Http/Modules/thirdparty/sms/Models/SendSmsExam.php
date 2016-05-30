<?php

namespace App\Http\Modules\thirdparty\sms\Models;

class SendSmsExam extends SendSmsModel
{
    protected $screenId = 2005;

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

    public function __construct($arguments)
    {
        parent::__construct($arguments);

        $this->smsBalanceCount = $this->smsBalanceCount();
        $this->smsAccountTypes = $this->repository->getSmsAccountTypes();
        $this->exam = $this->repository->getExam();
    }

    public function rows()
    {
        if (!is_null($this->filter_entity_id) && !is_null($this->filter_type)) {
            return $this->repository->examResults($this);
        }

        return [];
    }

}
