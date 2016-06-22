<?php

namespace App\Http\UserGroups;

class Group
{
    public static function isOwner()
    {
        $group = session()->get('user.userSecurityGroup');
        $group = trim($group);

        if ($group == 'SysAdmin' || $group == 'Owner') {
            return true;
        }

        return false;
    }

    public static function isParent()
    {
        $group = session()->get('user.userSecurityGroup');
        $group = trim($group);

        if ($group == 'Parent') {
            return true;
        }

        return false;
    }
}
