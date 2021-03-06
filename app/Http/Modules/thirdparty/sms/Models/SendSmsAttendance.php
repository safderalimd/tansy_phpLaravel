<?php

namespace App\Http\Modules\thirdparty\sms\Models;

class SendSmsAttendance extends SendSmsModel
{
    // todo: fix duplication
    protected $screenId = '/cabinet/send-sms---attendence';
    public static $staticScreenId = '/cabinet/send-sms---attendence';

    public function setHiddenAbsenseDateAttribute($value)
    {
        $this->setAttribute('absense_date', $value);
        return $value;
    }

    public function setDtAttribute($value)
    {
        $this->setAttribute('absense_date', $value);
        return $value;
    }

    public function rows()
    {
        $this->setAttribute('filter_entity_id', $this->allStudentsAccountId());
        $this->setAttribute('filter_type', 'All Students');
        return $this->repository->absenteesSmsResults($this);
    }

    public function setSmsBatchAttributes()
    {
        $this->setAttribute('sms_type_id', $this->getAbsenteesSmsTypeId());
        $this->setAttribute('sms_account_row_type', 'All Students');
        $this->setAttribute('sms_account_entity_id', $this->allStudentsAccountId());
        $this->setAttribute('exam_entity_id', null);
    }

    public function getAbsenteesSmsTypeId()
    {
        $smsTypes = $this->repository->getSmsTypes();

        foreach ($smsTypes as $item) {
            $type = trim($item['sms_type']);
            if ($type == 'Absentees') {
                return $item['sms_type_id'];
            }
        }

        return null;
    }

    public function allStudentsAccountId()
    {
        $accountTypes = $this->repository->getAccountTypeFilter();

        foreach ($accountTypes as $item) {
            $type = trim($item['row_type']);
            if ($type == 'All Students') {
                return $item['entity_id'];
            }
        }

        return null;
    }
}
