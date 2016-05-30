<?php

namespace App\Http\Modules\thirdparty\sms\Models;

class SendSmsAttendance extends SendSmsModel
{
    protected $screenId = 2006;

    public function setHiddenAbsenseDateAttribute($value)
    {
        $this->setAttribute('absense_date', $value);
        return $value;
    }

    public function __construct($arguments)
    {
        parent::__construct($arguments);

        $this->smsBalanceCount = $this->smsBalanceCount();

        if (!isset($this->absense_date)) {
            $this->setAttribute('absense_date', date('Y-m-j'));
        }
    }

    public function rows()
    {
        $absenteesSmsTypeId = $this->getAbsenteesSmsTypeId();
        $this->setAttribute('filter_entity_id', $absenteesSmsTypeId);
        $this->setAttribute('filter_type', 'All Students');
        return $this->repository->absenteesSmsResults($this);
    }

    public function getAbsenteesSmsTypeId()
    {
        $smsTypes = $this->repository->getSmsTypes();
        $absenteesSmsTypeId = null;
        foreach ($smsTypes as $type) {
            if (strtolower($type['sms_type']) == 'absentees') {
                $absenteesSmsTypeId = $type['sms_type_id'];
                break;
            }
        }
        return $absenteesSmsTypeId;
    }
}
