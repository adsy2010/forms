<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 18/04/2019
 * Time: 11:24 AM
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\PersonnelDetails;

class PersonnelController extends Controller
{
    public function listPersonnelDetails()
    {
        $personnel = PersonnelDetails::paginate(15);
        return view('admin.personnelList', ['personnel' => $personnel]);
    }

}