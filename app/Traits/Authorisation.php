<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 08/05/2019
 * Time: 21:15
 */

namespace App\Traits;


use Illuminate\Support\Facades\Auth;

trait Authorisation
{
    public function checkAuthorisedUser($id)
    {
        if(Auth::id() == $id) return true;
        return false;
    }

    /**
     * Checks if logged in user is a member of a specific group
     * @param string $group Group name to check
     * @return bool True if user is in group
     */
    public static function isInGroup($group)
    {
        return (in_array($group, json_decode(Auth::user()->groupmemberships->pluck('groupInfo')->pluck('name'), TRUE)));
    }

    /**
     * Checks if logged in user is a member of a specific group
     * @param integer $group Group ID to check
     * @return bool True if user is in group
     */
    public static function isInGroupID($group)
    {
        return (in_array($group, json_decode(Auth::user()->groupmemberships, TRUE)));
    }
}