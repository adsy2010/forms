<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuthGroupMember extends Model
{
    //
    protected $fillable = ['authGroup', 'priority', 'pattern', 'form'];

    public function groupData()
    {
        return $this->hasOne('App\Groups', 'id', 'authGroup');
    }

    public function formData()
    {
        return $this->hasOne('App\Form', 'id', 'form');
    }

    public function users()
    {
        return $this->hasManyThrough('App\User', 'App\GroupMembership', 'groupID', 'id', 'authGroup', 'userID');
    }
}
