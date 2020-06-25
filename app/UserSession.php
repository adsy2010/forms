<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 16/04/2019
 * Time: 17:04
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{

    protected $table = 'user_session';

    public $fillable = ['token', 'uid', 'raw'];

    public function getRouteKeyName()
    {
        return 'token';
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'uid', 'uid');
    }
}