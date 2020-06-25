<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuthGroupAuthorisation extends Model
{
    //
    protected $fillable = ['claim', 'user', 'authGroup', 'status'];

    public function claimData()
    {
        return $this->hasOne('App\Claim', 'id', 'claim');
    }

    public function userData()
    {
        return $this->hasOne('App\User', 'id', 'user');
    }

    public function groupData()
    {
        return $this->hasOne('App\Groups', 'id', 'authGroup');
    }

    public function statusData()
    {
        return $this->hasOne('App\ClaimStatus', 'id', 'status');
    }
}
