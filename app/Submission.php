<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    //
    protected $fillable = ['claim', 'chainPosition'];

    public function claimData(){
        return $this->hasOne('App\Claim', 'id', 'claim');
    }

    public function authGroupPriority(){
        return $this->hasMany('App\AuthGroupMember', 'priority', 'chainPosition');
    }
}
