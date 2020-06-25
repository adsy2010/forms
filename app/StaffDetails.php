<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 23/04/2019
 * Time: 22:46
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class StaffDetails extends Model
{
    protected $table = 'staffdetails';
    protected $fillable = ['userID', 'position', 'extension', 'firstaider'];
}