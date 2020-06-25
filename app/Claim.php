<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Claim extends Model
{
    protected $fillable = ['user', 'form', 'period', 'status'];
    /**
     * Claim status relationship
     *
     * @return HasOne
     */
    public function claimStatus()
    {
        return $this->hasOne('App\ClaimStatus', 'id', 'status');
    }

    /**
     * Claim form relationship
     *
     * @return HasOne
     */
    public function claimForm()
    {
        return $this->hasOne('App\Form', 'id', 'form');
    }

    /**
     * Claim user relationship
     *
     * @return HasOne
     */
    public function claimUser()
    {
        return $this->hasOne('App\User', 'id', 'user');
    }

    /**
     * Claim outcome relationship
     *
     * @return HasMany
     */
    public function outcome()
    {
        return $this->hasMany('App\Outcome', 'claim', 'id');
    }

    /**
     * Lines below belong to many sub forms relationships
     */

    /** Travel Claims */

    /**
     * @return HasMany
     */
    public function mileage()
    {
        return $this->hasMany('App\Mileage', 'claim', 'id');
    }

    /**
     * @return HasMany
     */
    public function parking()
    {
        return $this->hasMany('App\Parking', 'claim', 'id');
    }

    /**
     * @return HasMany
     */
    public function subsistence()
    {
        return $this->hasMany('App\Subsistence', 'claim', 'id');
    }

    /**
     * @return HasMany
     */
    public function transport()
    {
        return $this->hasMany('App\Transport', 'claim', 'id');
    }

    /** Hours Claims */

    /**
     * @return HasMany
     */
    public function hours()
    {
        return $this->hasMany('App\Hours', 'claim', 'id');
    }
}