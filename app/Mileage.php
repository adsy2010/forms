<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mileage extends Model
{
    //
    protected $fillable = [
        'claim',
        'vehicle',
        'mileageType',
        'mileageDate',
        'mileageTime',
        'mileage',
        'reason',
        'origin',
        'destination',
        'ppm',
        'amount'];
    public function claimData()
    {
        return $this->hasOne('App\Claim', 'id', 'claim');
    }

    public function mileageTypeData()
    {
        return $this->hasOne('App\MileageType', 'id', 'mileageType');
    }
}
