<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 17/04/2019
 * Time: 9:15 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    protected $table = 'groups';

    protected $fillable = ['name'];

    protected $guarded = ['id'];

    public function groupmemberships()
    {
        return $this->hasMany('App\GroupMembership', 'groupID', 'id');
    }

    public function users()
    {
        return $this->hasManyThrough('App\User', 'App\GroupMembership', 'groupID', 'id', 'id', 'userID');
    }
}