<?php

namespace App\Http\SMS;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Http\SMS\SMSManager
 */
class SMSFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sms';
    }
}
