<?php

namespace App\Http\Modules\thirdparty\sms\Models;

use App\Http\Models\Model;

class SendSms extends Model
{
    protected $screenId = 2004;

    protected $repositoryNamespace = 'App\Http\Modules\thirdparty\sms\Repositories\SendSmsRepository';

    public function feeReminders()
    {
        // iparam_filter_type = 'entity';
        // iparam_subject_entity_id =132;
        // iparam_return_type ='Detail';
        return $this->repository->feeReminders($this);
    }
}
