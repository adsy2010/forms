<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    protected $fillable = ['parkingDate', 'amount', 'claim'];
    //
    public function claimData()
    {
        return $this->hasOne('App\Claim', 'id', 'claim');
    }
}
