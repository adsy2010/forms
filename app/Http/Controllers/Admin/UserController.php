<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 16/04/2019
 * Time: 21:17
 */

namespace App\Http\Controllers\Admin;

use App\Groups;
use App\Http\Controllers\Controller;
use App\User;
use App\UserSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Exception;

class UserController extends Controller
{
    public function userSessions()
    {
        $usersession = UserSession::get();
        if (Route::current()->getName() == 'api.admin.users.sessions')
        {
            return response()->json(["status" => "OK", "data" => $usersession], 200);
        }
        return view('admin.userSessions', ['usersession' => $usersession]);
    }

    public function userDetails(Request $request)
    {
        $user = User::where('id', $request->id)->with('team', 'team.user', 'staffdetails', 'personneldetails', 'linemanager', 'linemanager.manager')->first();
        if (Route::current()->getName() == 'api.admin.user.view')
        {
            $roles = ['Students', '4015_ADP_-_All_Parents', 'Ofsted', 'Staff'];
            foreach($roles as $role) if($user->hasRole($role)) $mainRole = $role;
            return response()->json(["status" => "OK", "data" => [
                "user"=>$user,
                "photo_exists"=> file_exists(storage_path("app/public/images/staff/".strtoupper($user->uid).".jpg")),
                "role" => $mainRole
                ]], 200);
        }
        return view('admin.userDetails', ['user' => $user]);
    }

    public function createSession(Request $request)
    {
        //api route

        if(Route::current()->getName() == 'api.admin.users.sessions.create'){
            try{
                if(!$request->isMethod('post'))
                    return response()->json(['status'=>'Method not allowed'], 405);

                $validation = Validator::make($request->all(), [
                    'username' => 'required|max:64',
                    'token' => 'required|unique:user_session|max:64'
                ]);

                if ($validation->fails()) {
                    return response()->json(['status' => 'Validation failed'], 400);
                }

                if(UserSession::create([
                    'uid' => $request->username,
                    'token' => $request->token
                ]))
                    return response()->json(['status' => 'OK'], 200);
            }
            catch (Exception $exception){
                return response()->json(['status' => 'Something went wrong: ' . $exception->getMessage()], 500);
            }

        }

        //web route
        if(!$request->isMethod('post'))
            return redirect()->back()->withErrors('An attempt to access the create session method was made incorrectly.');
        $validation = Validator::make($request->all(), [
            'username' => 'required|max:64',
            'token' => 'required|unique:user_session|max:128'
        ]);

        if ($validation->fails()) {
            return redirect(Route('admin.sessions.view'))
                ->withErrors($validation)
                ->withInput($request->all())
                ->send();
        }

        if(UserSession::create([
            'uid' => $request->username,
            'token' => $request->token
        ]))
            return redirect()->back()->with('success', 'Successfully added a login token to the database');

        return response();

    }

    public function userList()
    {
        $users = User::paginate(15);
        if (Route::current()->getName() == 'api.admin.users.view')
        {
            return response()->json(["status" => "OK", "data" => $users], 200);
        }
        return view('admin.userList', ['users' => $users]);
    }

    public function staffList(){
        $role = "Staff";
        $members = Groups::with(['users'=>function($q){
            $q->select('users.id','FirstName','LastName');
            $q->orderBy('LastName', 'asc');
            $q->orderBy('FirstName','asc');
        }])
            ->where('name', '=',$role)
            ->get();
        return response()->json(['status' => 'ok', 'data' => $members]);
    }

    public function purgeSessions()
    {
        UserSession::truncate();
        if(Route::current()->getName() == 'api.admin.users.sessions.purge'){
            return response()->json(['status' => 'OK'], 200);
        }
        return redirect()->back();
    }
}