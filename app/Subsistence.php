<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subsistence extends Model
{
    //

    protected $fillable = ['subsistenceDate', 'amount', 'claim'];

    public function claimData()
    {
        return $this->hasOne('App\Claim', 'id', 'claim');
    }
}
