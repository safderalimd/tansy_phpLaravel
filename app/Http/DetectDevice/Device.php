<?php

namespace App\Http\DetectDevice;

use Detection\MobileDetect;

class Device
{
    protected static $detect = null;

    public static function type()
    {
        if (is_null(static::$detect)) {
            static::$detect = new MobileDetect;
        }

        if (static::$detect->isTablet()) {
            return 'tablet';
        }

        if (static::$detect->isMobile()) {
            return 'mobile';
        }

        return 'desktop';
    }

    public static function isAndroidMobile()
    {
        if (is_null(static::$detect)) {
            static::$detect = new MobileDetect;
        }

        if (static::$detect->isTablet()) {
            return false;
        }

        if (!static::$detect->isMobile()) {
            return false;
        }

        if (static::$detect->isAndroidOS()) {
            return true;
        }

        return false;
    }
}
