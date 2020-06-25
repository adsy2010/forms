<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 18/04/2019
 * Time: 10:30 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class PersonnelDetails extends Model
{
    protected $table = 'personnel_details';

    protected $fillable = ['userID', 'email', 'personnelNumber', 'niNumber'];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'userID');
    }
}