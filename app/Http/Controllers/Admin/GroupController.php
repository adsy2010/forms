<?php
/**
 * Created by PhpStorm.
 * User: awt
 * Date: 17/04/2019
 * Time: 3:22 PM
 */

namespace App\Http\Controllers\Admin;


use App\Groups;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class GroupController extends Controller
{

    public function groupList()
    {
        $groups = Groups::orderBy('name', 'ASC')->get();
        if (Route::current()->getName() == 'api.admin.groups.view')
        {
            return response()->json(['status'=>'OK', 'data'=>$groups], 200);
        }
        return view('admin.groupList', ['groups' => $groups]);
    }

    public function groupDetails(Request $request)
    {
        $groups = Groups::where('id', $request->id)->with('groupmemberships', 'groupmemberships.user')->first();
        if (Route::current()->getName() == 'api.admin.group.view') {
            return response()->json(["status" => "OK", "data" => $groups],200);
        }
        return view('admin.groupDetails', ['group' => $groups]);
    }

}