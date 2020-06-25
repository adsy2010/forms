<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    //
    protected $fillable = ['transportDate', 'transportType', 'amount', 'claim'];

    public function claimData()
    {
        return $this->hasOne('App\Claim', 'id', 'claim');
    }

    public function transportTypeName()
    {
        return $this->hasOne('App\TransportType', 'id', 'transportType');
    }
}
