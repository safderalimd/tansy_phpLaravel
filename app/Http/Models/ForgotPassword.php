<?php

namespace App\Http\Models;

use App\Http\Models\Model;
// use Device;
// use Session;

class ForgotPassword extends Model
{
    // protected $screenId = '/cabinet/change-password';

    protected $repositoryNamespace = 'App\Http\Modules\Admin\Repositories\ForgotPasswordRepository';

    // public function updatePassword()
    // {
    //     $this->setAttribute('ignore_old_password', 1);
    //     return $this->repository->update($this);
    // }

    // public function sendChangePasswordSMS()
    // {
    //     return $this->send_change_password_sms == 1;
    // }

    // public function userMobile()
    // {
    //     return $this->user_mobile;
    // }

    // public function getMessage()
    // {
    //     $device = Device::type();
    //     $time = current_time() . ', ' . current_date();
    //     return 'Your password has been changed at '.$time.' from '.$device.' with IP: '.userIp() . '.';
    // }
}
