<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransportType extends Model
{
    //

    public function transport()
    {
        return $this->hasMany('App\Transport', 'transportType', 'id');
    }
}