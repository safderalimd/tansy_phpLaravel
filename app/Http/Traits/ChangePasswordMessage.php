<?php

namespace App\Http\Traits;

use Device;

trait ChangePasswordMessage
{
    public function getChangePasswordMessage()
    {
        $device = Device::type();
        $time = current_time() . ', ' . current_date();
        return 'Your password has been changed at '.$time.' from '.$device.' with IP: '.userIp() . '.';
    }
}
