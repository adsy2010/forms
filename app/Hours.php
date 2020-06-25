<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hours extends Model
{
    //

    protected $fillable = ['claim','claimDate','hours'];

    public function hoursClaim()
    {
        return $this->hasOne('App\Claim', 'id', 'claim');
    }
}
