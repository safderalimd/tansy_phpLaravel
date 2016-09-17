<?php

namespace App\Http\Modules\Admin\Models;

use App\Http\Models\Model;
use Device;
use Session;

class ChangePassword extends Model
{
    protected $screenId = '/cabinet/change-password';

    protected $repositoryNamespace = 'App\Http\Modules\Admin\Repositories\ChangePasswordRepository';

    public function updatePassword()
    {
        // if (force_change_password()) {
        //     $this->setAttribute('ignore_old_password', 1);
        // } else {
        // }

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

    public function getMessage()
    {
        $device = Device::type();
        $time = current_time() . ', ' . current_date();
        return 'Your password has been changed at '.$time.' from '.$device.' with IP: '.userIp() . '.';
    }
}
