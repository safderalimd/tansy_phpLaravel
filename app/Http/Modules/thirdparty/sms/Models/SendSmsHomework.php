<?php

namespace App\Http\Modules\thirdparty\sms\Models;

class SendSmsHomework extends SendSmsModel
{
    // todo: fix duplication
    protected $screenId = '/cabinet/send-sms---homework';
    public static $staticScreenId = '/cabinet/send-sms---homework';

    public function setHiddenHomeworkDateAttribute($value)
    {
        $this->setAttribute('home_work_date', $value);
        return $value;
    }

    public function setAeiAttribute($value)
    {
        $this->setAttribute('filter_entity_id', $value);
        return $value;
    }

    public function setDtAttribute($value)
    {
        $this->setAttribute('home_work_date', $value);
        return $value;
    }

    public function rows()
    {
        // $this->setAttribute('filter_entity_id', $this->allStudentsAccountId());
        // $this->setAttribute('filter_type', 'All Students');
        return $this->repository->homeWork($this);
    }

    public function setSmsBatchAttributes()
    {
        $this->setAttribute('sms_type_id', $this->getHomeworkSmsTypeId());
        // $this->setAttribute('sms_account_row_type', 'All Students');
        // $this->setAttribute('sms_account_entity_id', $this->allStudentsAccountId());
        $this->setAttribute('sms_account_entity_id', 'filter_entity_id');
        $this->setAttribute('exam_entity_id', null);
    }

    public function getHomeworkSmsTypeId()
    {
        $smsTypes = $this->repository->getSmsTypes();

        foreach ($smsTypes as $item) {
            $type = trim($item['sms_type']);
            if (strtolower($type) == 'homework') {
                return $item['sms_type_id'];
            }
        }

        return null;
    }

    // public function allStudentsAccountId()
    // {
    //     $accountTypes = $this->repository->getAccountTypeFilter();

    //     foreach ($accountTypes as $item) {
    //         $type = trim($item['row_type']);
    //         if ($type == 'All Students') {
    //             return $item['entity_id'];
    //         }
    //     }

    //     return null;
    // }
}
