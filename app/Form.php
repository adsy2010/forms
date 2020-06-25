<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    //
    public function claims()
    {
        return $this->hasMany('App\Claim', 'form', 'id');
    }

    public function authGroups()
    {
        return $this->hasMany('App\AuthGroupMember', 'form', 'id')->orderBy('priority', 'ASC');
    }
}