<?php

namespace App\Http\SMS;

use App\Http\Modules\thirdparty\sms\Models\SendSmsModel;
use App\Http\SMS\Exceptions\NullProviderException;
use App\Http\SMS\Exceptions\InactiveProviderException;
use App\Http\SMS\Sender;
use App\Http\SMS\Providers\ProviderTextlocal;

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
        return new Sender($this->provider('SMS Text - Transactional'));
    }

    public function promotional()
    {
        return new Sender($this->provider('SMS Text - Promotional'));
    }

    public function otp()
    {
        return new Sender($this->provider('SMS Text - OTP'));
    }

    /**
     * Get the provider object for this route type.
     *
     * @param  string $route
     * @return object|null
     */
    public function provider($route)
    {
        $credentials = $this->credentialsFor($route);
        $this->checkAccountIsActive($credentials);

        $provider = isset($credentials['provider_name']) ? $credentials['provider_name'] : null;
        return $this->makeProvider($provider);
    }

    /**
     * Check if the current provider account is active.
     *
     * @param  array $credentials
     * @return void
     */
    public function checkAccountIsActive($credentials)
    {
        $isActive = isset($credentials['active']) ? $credentials['active'] : null;
        if ($isActive != 1) {
            throw new InactiveProviderException("SMS Provider Account is not activated.");
        }
    }

    /**
     * Return the corresponding sms provider implementation.
     *
     * @param  string $provider
     * @return Provider
     */
    public function makeProvider($provider)
    {
        if ($provider == 'Text Local') {
            return new ProviderTextlocal($this->model, $credentials);
        }

        throw new NullProviderException("Invalid SMS Provider.");
    }

    /**
     * Return the credentials for a route type.
     *
     * @param  string $route
     * @return array|null
     */
    public function credentialsFor($route)
    {
        foreach ((array)$this->credentials as $credential) {
            if (isset($credential['route_type'])) {
                return $credential;
            }
        }

        return null;
    }
}
