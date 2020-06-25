<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 17/04/2019
 * Time: 3:57 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = ['userID', 'subject', 'message', 'read'];

    public function getRouteKeyName()
    {
        return 'id';
    }

    protected $guarded = ['id'];
}