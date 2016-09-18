<?php

namespace App\Http\ForgotPassword;

use App\Http\Models\ForgotPassword;
use Cache;

trait PasswordThrottle
{
    /**
     * Extract the domain from the login field
     */
    protected function getDomain($request)
    {
        return last(explode('@', $request->input('login_field')));
    }

    protected function userIsLockedOut($domain)
    {
        if (Cache::has($this->getCacheKey($domain))) {
            return true;
        }

        return false;
    }

    protected function getLockedOutMessage($domain)
    {
        $availableIn = Cache::get($this->getCacheKey($domain)) - time();
        $minutes = $availableIn > 0 ? intval($availableIn / 60) : 1;
        return 'You have been locked out. Please try again in '.$minutes.' minutes.';
    }

    protected function lockOutUserFromDomain($domain)
    {
        $decayMinutes = 30;
        $expireTime = time() + ($decayMinutes * 60);
        Cache::add($this->getCacheKey($domain), $expireTime, $decayMinutes);
    }

    protected function getCacheKey($domain)
    {
        return $domain.'|'.userIp().':reset-password-lockout';
    }
}
