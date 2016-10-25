<?php

namespace App\Http\Modules\thirdparty\sms\Models;

use App\Http\Models\Model;
use Exception;

class SendSmsModel extends Model
{
    protected $repositoryNamespace = 'App\Http\Modules\thirdparty\sms\Repositories\SendSmsRepository';

    public $prefixType = '';

    public $trimLength = 301;

    public function __construct($arguments = [])
    {
        parent::__construct($arguments);
    }

    public function textlocalMessagePrefixes()
    {
        return $this->repository->textlocalMessagePrefixes();
    }

    public function credentials()
    {
        return $this->repository->credentials($this);
    }

    public function logSMS_V1()
    {
        return $this->repository->logSMS_V1($this);
    }

    public function logSMS_V2()
    {
        return $this->repository->logSMS_V2($this);
    }

    public function setSmsTypeIdChangePassword()
    {
        $this->setAttribute('sms_type_id', $this->smsTypeIdFor('Change Password'));
    }

    public function setSmsTypeIdLoginOTP()
    {
        $this->setAttribute('sms_type_id', $this->smsTypeIdFor('Login OTP'));
    }

    public function setSmsTypeIdLoginSMS()
    {
        $this->setAttribute('sms_type_id', $this->smsTypeIdFor('Login SMS'));
    }

    public function smsTypeIdFor($smsType)
    {
        $types = $this->repository->getSmsTypes();
        foreach ($types as $type) {
            if ($type['sms_type'] == $smsType) {
                return $type['sms_type_id'];
            }
        }

        return null;
    }
}
