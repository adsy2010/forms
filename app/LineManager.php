<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 23/04/2019
 * Time: 20:19
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class LineManager extends Model
{

    protected $table = 'linemanager';

    protected $fillable = ['userID', 'managerID'];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'userID');
    }

    public function manager()
    {
        return $this->hasOne('App\User', 'id', 'managerID');
    }
}