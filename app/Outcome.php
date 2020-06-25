<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Outcome extends Model
{
    protected $fillable =['claim', 'outcome'];
    //
    public function claimData()
    {
        return $this->hasOne('App\Claim', 'id', 'claim');
    }
}