<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 18/04/2019
 * Time: 12:52 PM
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\LineManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class PersonnelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function personnelDetails()
    {
        $personnel = Auth::user()->personneldetails;
        return view('user.personnelDetails', ['personnel' => $personnel]);
    }

    public function myTeam()
    {
        if (Route::current()->getName() == 'api.myteam.list')
        {
            return response()->json(["status" => "OK", "data" => ["team" => LineManager::where('managerID', Auth::id())->with('user', 'user.staffdetails')->get()]], 200);
        }
        return view('user.team', ['team' => Auth::user()->team]);
    }
}