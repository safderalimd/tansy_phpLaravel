<?php

namespace App\Http\SMS;

use App\Http\Modules\thirdparty\sms\Models\SendSmsModel;
use App\Http\SMS\Sender;
use App\Http\SMS\TextLocal\ProviderTextlocal;

/**
 * Choose the correct provider implementation for each route.
 */
class SMSManager
{
    protected $model;

    protected $credentials;

    public function __construct()
    {
        $this->model = new SendSmsModel;

        $this->credentials = $this->model->credentials();
    }

    public function transactional()
    {
        return $this->route('SMS Text - Transactional');
    }

    public function promotional()
    {
        return $this->route('SMS Text - Promotional');
    }

    public function otp()
    {
        return $this->route('SMS Text - OTP');
    }

    public function route($route)
    {
        $credentials = $this->credentialsForRoute($route);

        $provider = $this->makeProvider($this->getProviderName($credentials), $credentials);

        $isActive = $this->isAccountActive($credentials);

        return new Sender($provider, $isActive);
    }

    /**
     * Check if the current provider account is active.
     *
     * @param  array $credentials
     * @return boolean
     */
    public function isAccountActive($credentials)
    {
        $isActive = isset($credentials['active']) ? $credentials['active'] : null;
        return ($isActive == 1) ? true : false;
    }

    /**
     * Return the corresponding sms provider implementation.
     *
     * @param  string $provider
     * @param  array $credentials
     * @return Provider|null
     */
    public function makeProvider($provider, $credentials)
    {
        if ($provider == 'Text Local') {
            return new ProviderTextlocal(new SendSmsModel, $credentials);
        }

        return null;
    }

    /**
     * Return the credentials for a route type.
     *
     * @param  string $route
     * @return array|null
     */
    public function credentialsForRoute($route)
    {
        foreach ((array)$this->credentials as $credential) {
            if (isset($credential['route_type'])) {
                return $credential;
            }
        }

        return null;
    }

    /**
     * Returnt the provider name.
     *
     * @param  array $credentials
     * @return string|null
     */
    public function getProviderName($credentials)
    {
        return isset($credentials['provider_name']) ? $credentials['provider_name'] : null;
    }
}
