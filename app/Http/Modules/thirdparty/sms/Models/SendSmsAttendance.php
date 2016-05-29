<?php

namespace App\Http\Modules\thirdparty\sms\Models;

class SendSmsAttendance extends SendSmsModel
{
    protected $screenId = 2006;

    public function loadData()
    {
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
