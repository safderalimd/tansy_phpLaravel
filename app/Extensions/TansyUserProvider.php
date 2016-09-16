<?php

namespace App\Extensions;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use App\Extensions\TansyUser;
use App\Http\Models\User as UserModel;
use Session;

class TansyUserProvider implements UserProvider
{
    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        $attributes = Session::get('user_attributes');
        if (!is_null($attributes)) {
            return new TansyUser((array) $attributes);
        }

        return null;
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed   $identifier
     * @param  string  $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        return null;

        d('retrieveByToken: identifier, token');
        dd($identifier, $token);
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string  $token
     * @return void
     */
    public function updateRememberToken(UserContract $user, $token)
    {
        // d('updateRememberToken: user, token');
        // dd($user, $token);
        Session::put('updateRememberToken', $token);
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $user = new UserModel($credentials);

        // read and set the second database credentials from the master database
        $secondDBCredentials = $user->getConnectionDataForSecondDB();

        Session::put('dbConnectionData', $secondDBCredentials);
        UserModel::setSecondDBCredentials($secondDBCredentials);

        if ($user->login()) {
            Session::put('user.user_name', $user->user_name);
            Session::put('user.domain_name', trim($user->domain_name));

            Session::put('user.defaultFacilityId', $user->default_facility_id);

            Session::put('user.sessionID', $user->session_id);
            Session::put('user.userID', $user->user_id);
            Session::put('user.userSecurityGroup', $user->user_sec_group);
            Session::put('user.debugSproc', $user->debug_sproc);
            Session::put('user.auditScreenVisit', $user->audit_screen_visit);

            Session::put('user.companyName', $user->company_name);
            Session::put('dbMenuInfo', $user->menuInfo);
            Session::put('dbHiddenMenuInfo', $user->hiddenMenuInfo);

            // clear the sms balance from the session
            Session::put('smsBalance', null);
            Session::put('smsAccountInactive', null);

            Session::put('user_attributes', $user->getAttributes());

            // force change password
            Session::put('user.forceChangePassword', $user->forceChangePassword());
        }

        return new TansyUser((array) $user->getAttributes());
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        return $user->hasValidCredentials;
    }
}
