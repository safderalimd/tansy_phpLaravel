<?php

namespace App\Http\Modules\Admin\Models;

use App\Http\Models\Model;
use Device;
use Session;
use App\Http\Traits\ChangePasswordMessage;

class ChangePassword extends Model
{
    protected $screenId = '/cabinet/change-password';

    protected $repositoryNamespace = 'App\Http\Modules\Admin\Repositories\ChangePasswordRepository';

    use ChangePasswordMessage;

    public function updatePassword()
    {
        $this->setAttribute('ignore_old_password', 0);
        Session::put('user.forceChangePassword', null);
        return $this->repository->update($this);
    }

    public function sendChangePasswordSMS()
    {
        return $this->send_change_password_sms == 1;
    }

    public function userMobile()
    {
        return $this->user_mobile;
    }
}
