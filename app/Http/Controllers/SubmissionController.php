<?php

namespace App\Http\Controllers;

use App\Submission;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resources
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json(['status' => 'OK', 'data' => Submission::all()], 200);
    }

    public function my()
    {
        $submissions = Submission::with('claimData', 'claimData.claimForm', 'claimData.claimStatus')
            ->whereHas('claimData', function ($query) {
                $query->where('user', Auth::id());
            })->get();
        return response()->json(['status' => 'ok', 'data' => $submissions]);
    }

    public function myAuthorisations()
    {
        DB::enableQueryLog();
        /**
         * SELECT * from submissions
            INNER JOIN (SELECT users.uid, forms.id, forms.name, claims.id as claimsId from claims
            INNER JOIN submissions on submissions.claim = claims.id
            INNER JOIN forms on forms.forms.id = claims.form
            INNER JOIN users on claims.user = users.id) F on F.claimsId = submissions.claim
            INNER JOIN (SELECT auth_group_members.priority from auth_group_members
            INNER JOIN groupmembership ON auth_group_members.authGroup = groupmembership.groupID
            WHERE groupmembership.userID = 1) AG ON AG.priority = submissions.chainPosition
            group by submissions.claim;
         */
        $query = "SELECT * FROM submissions
      INNER JOIN (SELECT users.uid, forms.id, forms.name, claim_statuses.state, claims.period, claims.id as claimsId FROM claims
          INNER JOIN submissions ON submissions.claim = claims.id
          INNER JOIN forms ON forms.forms.id = claims.form
          INNER JOIN claim_statuses ON claims.status = claim_statuses.id
          INNER JOIN users ON claims.user = users.id) F ON F.claimsId = submissions.claim
      INNER JOIN (SELECT groupmembership.groupID, auth_group_members.form, auth_group_members.priority FROM auth_group_members
          INNER JOIN groupmembership ON auth_group_members.authGroup = groupmembership.groupID
          WHERE groupmembership.userID = ".Auth::id().") AG ON AG.priority = submissions.chainPosition AND AG.form = F.id
      LEFT JOIN (SELECT auth_group_authorisations.user, auth_group_authorisations.claim FROM auth_group_authorisations) AGA ON AGA.claim = F.claimsId AND AGA.user = ".Auth::id()."
WHERE AGA.user IS NULL
GROUP BY submissions.claim, AG.groupID";
        $submissions = DB::select($query);
        /**$submissions = DB::table('submissions')
            ->join('claims', 'submissions.claim', '=','claims.id')
            ->join('auth_group_members', 'submissions.chainPosition', '=','auth_group_members.priority')
            ->get();
        /*$submissions = Submission::with([
            'authGroupPriority',
            'authGroupPriority.groupData',
            'claimData',
            'claimData.claimUser',
            'claimData.claimForm.authGroups' => function($query){$query->where('chainPosition', 'auth_group_members.priority');},
            'claimData.claimStatus',
            'authGroupPriority.formData',// => function($query){$query->where('forms.id', 1);},
            //'authGroupPriority.formData',// => function($query){$query->where('forms.id', 1);},
            'authGroupPriority.users' => function($query){
                $query->where('users.id', Auth::id());
        }])->whereHas('authGroupPriority.users', function($query){
            $query->where('users.id', Auth::id());
        })/*->whereHas('authGroupPriority.formData', function($query){$query->where('forms.id', 1);})
            ->get();*/
        $q = DB::getQueryLog();
            //need to check user is allowed to look at some
        return response()->json(['status' => 'ok', 'data' => $submissions]);
    }

    /**
     * Helper function to store submitted claim
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request)
    {
        return $this->store($request);
    }

    public function retract(Request $request)
    {
        return $this->destroy(Submission::findOrFail($request->claim));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try {
            $submission = Submission::create([
                'claim' => $request->claim
            ]);
            $submission->save();
            return response()->json(['status' => 'OK', 'data' => $submission], 200);
        }
        catch (Exception $exception)
        {
            return response()->json(['status' => 'Failed'], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function show(Submission $submission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function edit(Submission $submission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Submission $submission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Submission $submission
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function destroy(Submission $submission)
    {
        // check user is allowed to retract claim

        //if so delete the submission and tell the claim to change the status back to draft
        $submission->delete();
        return response()->json(['status' => 'ok']);

    }
}
