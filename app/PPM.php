<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PPM extends Model
{
    //
    protected $table = 'ppm';
    protected $fillable = ['mileageType','effectivePeriod','amount'];

    public function mType(){
        return $this->hasOne('App\MileageType', 'id', 'mileageType');
    }

}