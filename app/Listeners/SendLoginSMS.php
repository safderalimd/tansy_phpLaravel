<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Session;
use Device;
use SMS;

class SendLoginSMS
{
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
        // send a login notice sms
        if ($this->shouldSendNoticeSMS()) {
            $this->smsWasSent();
            SMS::transactional()->loginSMS($this->getMobile(), $this->getSMSMessage());
        }
    }

    /**
     * Shoud the sms be sent.
     *
     * @return boolean
     */
    protected function shouldSendNoticeSMS()
    {
        return Session::get('user.sendLoginSMS');
    }

    /**
     * Mark the sms as sent for this browser session.
     *
     * @return void
     */
    public function smsWasSent()
    {
        Session::put('user.sendLoginSMS', false);
    }

    /**
     * Get the mobile number to send the otp.
     *
     * @return int
     */
    protected function getMobile()
    {
        return Session::get('user.user_mobile');
    }

    /**
     * Get the sms notice message.
     *
     * @return string
     */
    protected function getSMSMessage()
    {
        $user = $this->getLogin();
        $time = date("d-M-Y H:m:s", time());
        $device = Device::type();
        $ip = userIp();
        // return "The user {$user} logged into the system at time {$time} from {$device} device, using IP {$ip}.";
        return "Login SMS: {$user} logged at {$time} from {$device}, IP {$ip}.";
    }

    /**
     * Get the login username@domain value.
     *
     * @return string
     */
    protected function getLogin()
    {
        $userName = Session::get('user.user_name');
        $domain = Session::get('user.domain_name');
        return $userName.'@'.$domain;
    }
}
