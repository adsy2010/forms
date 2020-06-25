<?php

namespace App\Http\Controllers;

use App\AuthGroupMember;
use App\GroupMembership;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthGroupMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        return response()->json(['status' => 'OK', 'data' => AuthGroupMember::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        return response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //                        formId: this.formId,
        //                        priority: this.priority,
        //                        groupId: this.groupId,
        //                        pattern: this.pattern,
        try {
            $authGroupMember = AuthGroupMember::create([
                'authGroup' => $request->groupData['groupId'],
                'priority' => $request->groupData['priority'],
                'pattern' => $request->groupData['pattern'],
                'form' => $request->groupData['formId'],
            ]);
            $authGroupMember->save();
            return response()->json(['status' => 'OK', 'data' => $authGroupMember], 200);
        }
        catch (Exception $exception)
        {
            return response()->json(['status' => 'Failed'], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
        return response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
        return response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
        return response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
        $member = AuthGroupMember::find($id);
        $form = $member->form;
        AuthGroupMember::destroy($id);
        $this->reprioritise($form);
        return response()->json(['status' => 'OK'], 200);
    }

    /**
     * Run function to ensure there are no gaps in the priority list for the specified form
     *
     * 1,2,3,5 -> 1,2,3,4
     */
    private function reprioritise($form)
    {
        $priority = 1;
        $members = AuthGroupMember::where('form', $form)->orderBy('priority', 'ASC')->get();
        foreach($members as $member)
        {
            $member->priority = $priority;
            $member->save();
            $priority++;
        }
    }

    public function myGroups(){

        //$all = AuthGroupMember::all();

        /**
         * all groups per group membership
         * membership per user -> form
         */
        $data = AuthGroupMember::with(['formData', 'groupData'])
            ->whereHas('users', function(Builder $query){
                $query->where('users.id', Auth::id());
        })->get();

        /**
         * groups per group membership
         * group membership -> authgroups per user
         */
        //$data = GroupMembership::whereHas('authGroups')
        //    ->where('userID', Auth::id())
        //    ->with(['authGroups', 'authGroups.formData', 'groupInfo'])->get();

        return response()->json(['status' => 'ok', 'data' => $data], 200);
    }
}
