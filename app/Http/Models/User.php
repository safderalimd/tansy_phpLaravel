<?php

namespace App\Http\Models;

use App\Http\Models\Model;
use App\Http\Repositories\MasterDBRepository;
use Device;

class User extends Model
{
    protected $screenId = null;

    protected $repositoryNamespace = 'App\Http\Repositories\UserRepository';

    public $menuInfo;

    public $hiddenMenuInfo;

    public function setLoginAttribute($login)
    {
        $userName = head(explode('@', $login));
        $this->setAttribute('user_name', $userName);
        return $login;
    }

    public function login()
    {
        $this->setAttribute('login_media', Device::type());
        $this->setAttribute('login_name', $this->user_name);
        $this->setAttribute('ipaddress', userIp());
        $this->setAttribute('user_id', null);
        $data = $this->repository->login($this);
        $this->menuInfo = first_resultset($data);
        $this->hiddenMenuInfo = second_resultset($data);

        $this->attributes['hasValidCredentials'] = false;
        return $this->userIsLoggedIn();
    }

    public function retrieveByToken($token, $identifier)
    {
        $this->setAttribute('login_token', $token);
        $this->setAttribute('user_id', $identifier);
        $this->setAttribute('ipaddress', userIp());
        $data = $this->repository->login($this);
        $this->menuInfo = first_resultset($data);
        $this->hiddenMenuInfo = second_resultset($data);

        return $this->userIsLoggedIn();
    }

    public function userIsLoggedIn()
    {
        if ($this->err_flag == 1) {
            return false;
        }

        if ($this->login_success == 1 && !empty($this->menuInfo)) {
            $this->attributes['hasValidCredentials'] = true;
            return true;
        }

        return false;
    }

    public function updateRememberToken($token)
    {
        $this->setAttribute('login_token', $token);
        $this->setAttribute('login_token_ip', userIp());
        $this->setAttribute('login_media', Device::type());
        $this->setAttribute('screen_id', screen_id_from_hidden_menu_info('/login'));
        return $this->repository->updateRememberToken($this);
    }

    public function logout()
    {
        return $this->repository->logout($this);
    }

    public function forceChangePassword()
    {
        return $this->force_change_password == 1;
    }

    public function forceLoginOTPCode()
    {
        return $this->send_login_otp == 1;
    }
}
