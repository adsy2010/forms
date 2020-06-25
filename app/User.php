<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = ['id'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uniqueID', 'uid', 'FirstName', 'LastName', 'email',
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    public function unreadMessages()
    {
        return $this->hasMany('App\Message', 'userID', 'id')->where('read', 0);
    }

    public function messages()
    {
        return $this->hasMany('App\Message', 'userID', 'id');
    }

    public function groupmemberships()
    {
        return $this->hasMany('App\GroupMembership', 'userID', 'id');
    }

    public function personneldetails()
    {
        return $this->hasOne('App\PersonnelDetails', 'userID', 'id');
    }

    public function linemanager()
    {
        return $this->hasOne('App\LineManager', 'userID', 'id');
    }

    public function team()
    {
        return $this->hasMany('App\LineManager', 'managerID', 'id');
    }

    public function staffdetails()
    {
        return $this->hasOne('App\StaffDetails', 'userID', 'id');
    }

    public function hasRole($role)
    {
        return (in_array($role, json_decode($this->groupmemberships->pluck('groupInfo')->pluck('name'), TRUE)));
    }

    public function hasRoleID($role)
    {
        return (in_array($role, json_decode($this->groupmemberships->pluck('groupInfo')->pluck('id'), TRUE)));
    }

    public function myAuthGroups()
    {
        return $this->hasManyThrough('App\AuthGroupMember','App\GroupMembership', 'userID', 'authGroup', 'id', 'groupID');
    }
}
