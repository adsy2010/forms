<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MileageType extends Model
{
    //
    public function mileage()
    {
        return $this->hasMany('App\Mileage', 'mileageType', 'id');
    }

    public function ppm(){
        return $this->hasMany('App\PPM', 'mileageType', 'id')->orderBy('effectivePeriod', 'DESC');
    }
}
