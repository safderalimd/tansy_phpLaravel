<?php

namespace App\Http\Modules\thirdparty\sms;

class SMS
{
    protected $route;

    public function __construct($route)
    {
        $this->route = $route;
    }

    public static function transactional()
    {
        return new static('transactional');
    }

    public static function promotional()
    {
        return new static('promotional');
    }

    public static function otp()
    {
        return new static('otp');
    }

    public function oneSMS($phoneNumber, $textMessage)
    {
        d($phoneNumber);
        d($textMessage);
    }
}
