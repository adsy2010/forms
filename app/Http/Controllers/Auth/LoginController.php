<?php

namespace App\Http\Controllers\Auth;

use App\GroupMembership;
use App\Groups;
use App\Http\Controllers\Controller;
use App\PersonnelDetails;
use App\StaffDetails;
use App\User;
use App\UserSession;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/v2#/user';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    private function linkStaffDetails($data, $user)
    {
        $validation = Validator::make($data, [
            'position' => 'required'
        ]);

        if($validation->fails())
            return null;

        $fields = ['position', 'extension'];
        $info = array();
        $info['userID'] = $user->id;
        foreach ($fields as $field)
        {
            if (!empty($data[$field]))
                $info[$field] = $data[$field][0];
        }


        return StaffDetails::firstOrCreate($info);
    }

    private function linkPersonnelDetails(User $user)
    {
        try{
            $details = PersonnelDetails::where(['email' => $user->email, 'userID' => null])->first();
            if(!empty($details))
            {
                $details->userID = $user->id;
                $details->save();
            }
        }
        catch (Exception $exception) { return false; }

        return true;
    }

    private function checkAndSetupUser($data)
    {
        $validation = Validator::make($data, [
            'uniqueID' => 'required|exists:users,uniqueID',
            'FirstName' => 'required',
            'LastName' => 'required',
            'uid' => 'required',
            'mail' => 'required',
        ]);

        if ($validation->fails()) {
            return User::firstOrCreate([
                'uniqueID' => htmlspecialchars($data['uniqueID'][0]),
                'FirstName' => $data['FirstName'][0],
                'LastName' => $data['LastName'][0],
                'uid' => $data['uid'][0],
                'email' => $data['mail'][0],
                'remember_token' => 0
            ]);
        }
        return null;
    }

    private function checkAndUpdateUserGroups($data, $tokenuser)
    {

        $groupIDList = array();
        foreach ($data['GroupMemberships'] as $membership) {
            $group = Groups::updateOrCreate(['name' => $membership]);
            $groupIDList[] = ['groupID' => $group->id];
            GroupMembership::updateOrCreate(['userID' => $tokenuser->id, 'groupID' => $group->id]);

        }
        GroupMembership::where('userID', $tokenuser->id)->whereNotIn('groupID', $groupIDList)->delete();

    }

    public function validateToken(Request $request, $username, UserSession $token)
    {
        //$token->delete();
        if(!empty($token->raw)) {
            $data = json_decode($token->raw, TRUE);
            $user = $this->checkAndSetupUser($data);
        }

        $tokenuser = (!isset($token->user)) ? $user : $token->user;

        if(!empty($token->raw))
        {
            $this->checkAndUpdateUserGroups($data, $tokenuser);
        }
        if(in_array('Staff', json_decode($tokenuser->groupmemberships->pluck('groupInfo')->pluck('name'))))
        {
            $this->linkPersonnelDetails($tokenuser);
            if(!empty($token->raw)) {
                $this->linkStaffDetails($data, $tokenuser);
            }
        }
        Auth::login($tokenuser, 1); // Session wouldn't remain without remembering login.

        //TODO: clear used session token here

        return redirect()->to('/v2#/user');
    }

    public function updateToken(Request $request, $username, $token)
    {
        if(!$request->isMethod('post'))
            return redirect()->back()->with('error', 'Unable to perform action as method is not post');

        $userSession = UserSession::create([
            'token' => $token,
            'uid' => $username,
            'raw' => json_encode($request->raw)
        ]);
        $userSession->save();
        return response()->json(['status' => 'OK', "data"=>$request->raw],200);
    }
}
