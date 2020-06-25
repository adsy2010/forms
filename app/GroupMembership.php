<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 17/04/2019
 * Time: 10:28 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class GroupMembership extends Model
{
    protected $table = 'groupmembership';

    protected $fillable = ['userID', 'groupID'];


    public function user()
    {
        return $this->hasOne('App\User', 'id', 'userID');
    }

    public function groupInfo()
    {
        return $this->hasOne('App\Groups', 'id', 'groupID');
    }

    public function authGroups(){
        return $this->hasMany('App\AuthGroupMember', 'authGroup', 'groupID');
    }
}