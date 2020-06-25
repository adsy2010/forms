<?php

namespace App\Http\Controllers;

use App\AuthGroupAuthorisation;
use App\AuthGroupMember;
use App\Claim;
use App\ClaimStatus;
use App\GroupMembership;
use App\Outcome;
use App\Submission;
use App\Traits\Messaging;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthGroupAuthorisationController extends Controller
{
    use Messaging;
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        //
        return response()->json(['status' => 'OK' ,  'data' => AuthGroupAuthorisation::all()]);
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
     * @param  Request  $request
     * @return Response|JsonResponse
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try
        {
            //SET AUTHORISATION TO APPROVED OR REJECTED
            // 1: Approve
            // 0: Deny
            if(!$this->setAuthorisation($request))
                throw new Exception('Failed to set authorisation');

            //CHECK FOR REJECT
            if(!($request->status > 0)) //reject
            {
                if(!$this->setClaimStatus($request->claim, $this->getClaimStatusId('Rejected')))
                    throw new Exception('Setting claim status to in progress, failed.');

                if(!$this->setOutcome($request->claim, "Claim was rejected"))
                    throw new Exception('Setting claim outcome failed.');
            }
            //APPROVE
            else
            {
                //CHECK CLAIM IS SUBMITTED
                if($this->isClaimSubmitted($request->claim))
                {
                    if(!$this->setClaimStatus($request->claim, $this->getClaimStatusId('In Progress')))
                        throw new Exception('Setting claim status to in progress, failed.');
                }

                //can we update authorisation level?
                if($this->updateAuthorisationLevel($request))
                {
                    //if we did update the level now we need to check if there's a new group


                    $exists = $this->authGroupMembersExist(
                        $request->authGroup,
                        $this->getSubmission($request->claim)->chainPosition,
                        $this->getClaim($request->claim)->form
                    );

                    //FINALISE CLAIM
                    if(!$exists) $this->completeAuthorisationChain($request->claim);
                }
            }
            DB::commit();
            return response()->json(['status' => 'OK'], 200);
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return response()->json(['status' => 'Failed', 'error'=>$exception->getMessage()], 500);
        }
    }

    public function c(Request $request){
        return response()->json(['isClaimInProgress' => $this->isClaimInProgress($request->id)]);
    }

    /**
     * Updates the authorisation level for a submission if required
     *
     * @param Request $request
     * @return bool Returns true on success, false otherwise
     * @throws Exception Exceptions are generated if any database store actions fail
     */
    private function updateAuthorisationLevel(Request $request)
    {
        //GET PATTERN
        $pattern = $this->allOrOne(
            $request->authGroup,
            $this->getSubmission($request->claim)->chainPosition,
            $this->getClaim($request->claim)->form
        );

        if(!($pattern > 0))
        {
            if(!$this->increaseChainLevel($request->claim)) //upgrade level
                throw new Exception('Failed to increase chain level.');

            $exists = $this->authGroupMembersExist(
                $request->authGroup,
                $this->getSubmission($request->claim)->chainPosition,
                $this->getClaim($request->claim)->form
            );

            if($exists){
                if(!$this->sendNotification($request->claim))
                    throw new Exception('Unable to send notification');
            }
        }
        else
        {
            //pull group size and total number of authorisations for this group for this claim
            $groupSize = $this->sizeOfGroup($request->authGroup);
            $authorisationCount = $this->numberOfAuthorisations($request->claim, $request->authGroup);
            if($groupSize === $authorisationCount)
            {
                if(!$this->increaseChainLevel($request->claim)) //upgrade level
                    throw new Exception('Failed to increase chain level.');

                $exists = $this->authGroupMembersExist(
                    $request->authGroup,
                    $this->getSubmission($request->claim)->chainPosition,
                    $this->getClaim($request->claim)->form
                );

                if($exists)
                    if(!$this->sendNotification($request->claim))
                        throw new Exception('Unable to send notification');
                return true;
            }
            return false;
        }
        return true;
    }

    /**
     * Increases the chain level of a submission for a given claim
     *
     * @param int $claimId Claim ID of a submission to increase the current chain level
     * @return bool Returns true on success, false otherwise
     */
    private function increaseChainLevel($claimId)
    {
        try
        {
            $claim = Submission::where([['claim', '=', $claimId]])->first();
            $claim->chainPosition += 1;
            $claim->save();
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return false;
        }
        return true;
    }

    /**
     * Sets the claim status to the specified status level
     *
     * @param int $claim The current claim ID
     * @param int $status The status ID for the claim status
     * @return bool Returns true on success, false otherwise
     */
    private function setClaimStatus($claimId, $status)
    {
        try
        {
            $claim = Claim::find($claimId);
            $claim->status = $status;
            $claim->save();
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return false;
        }
        return true;
    }

    /**
     * Create the authorisation for the current authorising user
     *
     * @param Request $request
     * @return bool Returns true on success, false otherwise
     */
    private function setAuthorisation(Request $request)
    {
        try {
            $authGroupAuthorisation = AuthGroupAuthorisation::create([
                'claim' => $request->claim,
                'user' => Auth::id(),
                'authGroup' => $request->authGroup,
                'status' => $request->status,
            ]);
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return false;
        }
        return true;
    }

    /**
     * Sets the overall outcome for the current claim
     *
     * @param int $claim The current claim ID
     * @param string $outcome The outcome for the submission
     * @return bool Returns true on success, false otherwise
     */
    private function setOutcome($claim, $outcome)
    {
        try
        {
            Outcome::create([
                'claim' => $claim,
                'outcome' => $outcome
            ]);
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return false;
        }
        return true;
    }

    /**
     * Send a notification to the next authorisation group members
     *
     * @param int $claimId The current claim ID
     * @throws Exception
     */
    private function sendNotification($claimId)
    {
        //don't set anything yet
        try
        {

            $claim = $this->getClaim($claimId);

            $subject = 'Claim for authorisation';
            $message = "A claim for authorisation for the {$claim->claimForm['name']} form
        has been sent to you for approval. If you are one of a group required to sign off this approval, 
        please check 'My Authorisations' from the dashboard. If you have a query about this claim, 
        please use claim ID {$claim->id} in any communication with IT Services.";

            $authGroup = AuthGroupMember::where([
                ['priority','=',$this->getSubmission($claimId)->chainPosition],
                ['form','=',$claim->form],
            ])->first();

            $memberships = GroupMembership::with('user')->where('groupID', $authGroup->authGroup)->get();
            //throw new Exception('Failed here - Message: ' . $memberships);

            foreach ($memberships as $membership)
            {
                if(!$this->sendMessage($membership->user, $subject, $message))
                    throw new Exception('Unable to send message to '.$membership->user['id']);
            }
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            //return $exception->getMessage();
            return false;
        }
        return true;


    }

    /**
     * Retrieve a submission based on the claim ID
     *
     * @param int $claimId The current claim ID
     * @return Submission Returns one submission based on the claim ID
     */
    private function getSubmission($claimId)
    {
        return Submission::where('claim', $claimId)->first();
    }

    /**
     * Retrieve a claim based on the claim ID
     *
     * @param int $claimId The current claim ID
     * @return Claim|Builder|Builder[]|Collection|Model The claim
     */
    private function getClaim($claimId)
    {
        return Claim::with('claimStatus', 'claimForm')->find($claimId);
    }

    /**
     * Checks to see if the current status of the claim is submitted
     *
     * @param int $claim The claim ID in question
     * @return bool returns true if claim's status is submitted, false otherwise
     */
    private function isClaimSubmitted($claim)
    {
        return strstr($this->getClaim($claim)->claimStatus['state'], 'Submitted')?true:false;
    }

    /**
     * Checks to see if the current status of the claim is in progress
     *
     * @param int $claim The claim ID in question
     * @return bool returns true if claim's status is in progress, false otherwise
     */
    private function isClaimInProgress($claim)
    {
        return strstr($this->getClaim($claim)->claimStatus['state'], 'In Progress')?true:false;
    }

    /**
     * Checks to see if there are any authorisation groups for the given priority for a particular form
     *
     * @param int $authGroup The authorisation group ID
     * @param int $priority The priority level
     * @param int $form The form ID
     * @return bool Returns true if one exists, false otherwise
     */
    private function authGroupMembersExist($authGroup, $priority, $form)
    {
        $agm = AuthGroupMember::where([
            ['priority', '=', $priority],
            ['form', '=', $form],
        ])->count();
        return ($agm > 0);
    }

    /**
     * Retrieves a given authorisation groups pattern based on a given priority and form
     *
     * @param int $authGroup The authorisation group to check
     * @param int $priority The priority level to check
     * @param int $form The form ID to check
     * @return int Returns a number based on an all or one pattern value
     */
    private function allOrOne($authGroup, $priority, $form)
    {
        $agf = AuthGroupMember::where([
            ['authGroup','=', $authGroup],
            ['priority','=', $priority],
            ['form','=', $form],
        ])->first();
        return $agf->pattern;
    }

    /**
     * Count the number of authorisations for a given claim for a particular authorisation group
     *
     * @param int $claimId The current claim ID
     * @param int $groupId The current authorisation group ID
     * @return int Returns the number of total authorisations for the current claim ID
     */
    private function numberOfAuthorisations($claimId, $groupId)
    {
        $agas = AuthGroupAuthorisation::where([
            ['claim', '=', $claimId],
            ['authGroup', '=', $groupId]
        ])->count();
        return $agas;
    }

    /**
     * Count the total number of members of a given authorisation group
     *
     * @param int $authGroup The authorisation group to check
     * @return int Returns the total number of members of the given authorisation group
     */
    private function sizeOfGroup($authGroup)
    {
        return GroupMembership::where('groupID', $authGroup)->count();
    }

    /**
     * Retrieves the ID of a claim status by status name
     *
     * @param string $status The status name to check for an ID
     * @return int Returns the claim status ID for the given status
     */
    private function getClaimStatusId($status)
    {
        return ClaimStatus::where('state', 'LIKE', "%{$status}%")->first()->id;
    }

    /**
     * Closes the claims authorisation chain and sets a claim outcome to approved
     *
     * @param int $claimId The current claim ID
     * @throws Exception Throws an exception if database actions fail
     */
    private function completeAuthorisationChain($claimId)
    {
        if (!$this->setClaimStatus($claimId, $this->getClaimStatusId('Authorised')))
            throw new Exception('Setting claim status to approved, failed.');

        if (!$this->setOutcome($claimId, "Claim was authorised."))
            throw new Exception('Setting outcome failed.');
    }

    /**
     * Display the specified resource.
     *
     * @param  AuthGroupAuthorisation  $authGroupAuthorisation
     * @return Response
     */
    public function show(AuthGroupAuthorisation $authGroupAuthorisation)
    {
        //
        return response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AuthGroupAuthorisation  $authGroupAuthorisation
     * @return Response
     */
    public function edit(AuthGroupAuthorisation $authGroupAuthorisation)
    {
        //
        return response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  AuthGroupAuthorisation  $authGroupAuthorisation
     * @return Response
     */
    public function update(Request $request, AuthGroupAuthorisation $authGroupAuthorisation)
    {
        //
        return response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AuthGroupAuthorisation  $authGroupAuthorisation
     * @return Response
     */
    public function destroy(AuthGroupAuthorisation $authGroupAuthorisation)
    {
        //
        return response();
    }
}
