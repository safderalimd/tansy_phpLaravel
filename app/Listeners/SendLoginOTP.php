<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Modules\Admin\Controllers\Traits\LoginOTPThrottle;
use SMS;

class SendLoginOTP
{
    use LoginOTPThrottle;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        if (force_login_otp()) {

            // store it in the cache for the current user id, for 10 minutes
            $this->storeLoginOTPCode();

            // send login otp SMS
            SMS::otp()->loginOTP($this->getMobile(), $this->getLoginOTPMessage());
        }
    }
}
