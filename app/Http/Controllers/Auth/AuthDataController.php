<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;

class AuthDataController extends Controller
{
    /*
     * Pulls authenticated data for a user
     * Data pulled contains: Current authenticated user, team members
     */
    public function authData()
    {
        //Use roles listed here to determine main role in order of importance, left to right
        $roles = ['Students', '4015_ADP_-_All_Parents', 'Ofsted', 'Staff'];
        foreach($roles as $role) if(Auth::user()->hasRole($role)) $mainRole = $role;

        return response()->json(["status" => "OK", "data"=>[
            "user" => Auth::guard('api')->user(),
            "photo_exists"=> file_exists(storage_path("app/public/images/staff/".strtoupper(Auth::user()->uid).".jpg")),
            "role" => $mainRole
        ]]);
    }

    public function generateSession()
    {

    }
}