<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimStatus extends Model
{
    protected $fillable = ['state'];
    //
    public function claimData()
    {
        return $this->hasOne('App\Claim', 'status', 'id');
    }
}