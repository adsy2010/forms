<?php

namespace App\Http\Controllers;

use App\Claim;
use App\ClaimStatus;
use App\Form;
use App\Hours;
use App\Submission;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class ClaimsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|JsonResponse|Response|View
     */
    public function index()
    {
        //
        //return response()->json(["data" => Route::current()->getName()]);//Route::current();
        if (Route::current()->getName() == 'claim.index')
        {
            //return response()->json(['data' => Auth::user()]);
            return response()->json(["status" => "OK", "data" => Claim::where('user', Auth::id())->with("claimStatus", "claimUser", "claimForm")->get()], 200);
        }
        return view('v2.Claims.index', ['claims' => Claim::with('claimStatus')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|Response|View
     */
    public function create()
    {
        //
        return view('v2.Claims.create');
    }

    /**
     * Retract a claims status from submitted to draft and remove the submission from the database
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function retract(Request $request)
    {
        DB::beginTransaction();
        try{
            $claim = Claim::with('claimStatus')->find($request->id); //get the claim in question

            if(!strstr($claim->claimStatus->state, 'Submitted'))
                throw new Exception('Claim is not in the submitted state.');

            //we can do the retract
            //delete the submission
            if(!($submission = Submission::where('claim', $request->id)->firstOrFail()->delete()))
                throw new Exception('There was a problem deleting the submission');

            if (!$this->setClaimStatus($request->id, $this->getClaimStatusId('Draft')))
                throw new Exception('Setting claim status to draft, failed.');
        }
        catch (Exception $exception)
        {
            DB::rollBack();
        }
        DB::commit();
        return response()->json(['status' => 'ok']);
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
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Response
     */
    public function store(Request $request)
    {
        //need to verify form is included or fail

        // should be submitted by ID instead now
        // $form = Form::where('name', 'LIKE', $request->form)->first();
        if(!$request->isMethod('post'))
            return response()->json(['status' => 'Failed', 'message' => 'Expecting posted data']);

        DB::beginTransaction();

        try{
            if(!$claim = $this->createClaim($request))
                throw new Exception('Creating claim failed.');

            if(!($form = Form::find($request->formId)))
                throw new Exception('Failed to find requested form.');

            if(!$this->createScaffolds($form->name, $claim))
                throw new Exception('Unable to create scaffolds.');
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return response()->json(['status' => 'Failed', 'error' => $exception->getMessage()]);
        }

        DB::commit();

        return response()->json(['status' => 'OK', 'data' => $claim->id], 200);
    }

    /**
     * @param Request $request
     * @return bool|Claim
     */
    private function createClaim(Request $request)
    {
        try {
            // create a new claim
            $claim = Claim::create([
                'user' => Auth::id(),
                'form' => $request->formId,
                'period' => $request->period,
                'status' => 0
            ]);
            $claim->save();
            return $claim;
        }
        catch(Exception $exception)
        {
            DB::rollBack();
            return false;
        }
    }

    private function createScaffolds($form, Claim $claim)
    {
        //create time claim scaffold

        if(stristr($form, 'Time Claim')){
            if(!$this->createTimeScaffold($claim->id, $claim->period))
                return false;
        }
        return true;
    }

    private function createTimeScaffold($claim, $period)
    {
        // This method must create an item for EVERY day in the month for a specific claim ID
        // $request->period should be in format YYYYMM
        // $request->claim
        //return response()->json(['status' => 'ok', 'DD' => $period]);
        try{
            $days = Carbon::createFromFormat('Ym', $period)->daysInMonth;
            for($x = 1; $x <=$days; $x++)
            {
                $hours = Hours::create([
                    "claim" => $claim,
                    "claimDate" => Carbon::createFromFormat('Ymd', $period.$x)->toDateString(),
                    "hours" => 0
                ]);
                $hours->save();
            }
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return false;
        }
        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Factory|Response|View
     */
    public function show($id)
    {
        //
        if (Route::current()->getName() == 'api.myclaim')
        {
            return response()->json(["status" => "OK", "data" => Claim::where('id', $id)
                ->with(["claimStatus", "claimUser", "claimForm"])->first()], 200);
        }
        return view('v2.Claims.index', ['claims' => Claim::with('claimStatus')->get()]);
    }

    /**
     * GET Request Travel claims for current user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function travel(Request $request)
    {
        $travelclaims = Claim::where('user', Auth::id())
            ->with('claimStatus')
            ->whereHas('claimForm', function ($query) {
                $query->where('name', 'LIKE', '%travel%');
            })
            ->get();
        if (Route::current()->getName() == 'api.myclaims.travel')
        {
            return response()->json(["status" => "OK", "data" => ["travelclaims" => $travelclaims]], 200);
        }
        return response()->json(["status" => "Error", "message" => "Something went wrong!"], 401);
    }

    public function myTravelClaim(Request $request)
    {
        return $this->getTravelClaimDataByUser($request, Auth::id());
    }

    public function getTravelClaim(Request $request)
    {
        return $this->getTravelClaimDataById($request);
    }

    private function getTravelClaimDataById(Request $request)
    {
        $travelclaim = Claim::with(['mileage', 'transport', 'subsistence', 'parking', 'transport.transportTypeName'])
            ->where('id', $request->id)
            ->whereHas('claimForm', function ($query) {
                $query->where('name', 'LIKE', '%travel%');
            })
            ->first();
        if (Route::current()->getName() == 'api.claim.travel')
        {
            return response()->json(["status" => "OK", "data" => ["travelclaim" => $travelclaim]], 200);
        }
        return response()->json(["status" => "Error", "message" => "Something went wrong!"], 401);
    }

    private function getTravelClaimDataByUser(Request $request, $user)
    {
        $travelclaim = Claim::where('user', $user)
            ->with(['mileage', 'transport', 'subsistence', 'parking', 'transport.transportTypeName'])
            ->where('id', $request->id)
            ->whereHas('claimForm', function ($query) {
                $query->where('name', 'LIKE', '%travel%');
            })
            ->first();
        if (Route::current()->getName() == 'api.myclaim.travel')
        {
            return response()->json(["status" => "OK", "data" => ["travelclaim" => $travelclaim]], 200);
        }
        return response()->json(["status" => "Error", "message" => "Something went wrong!"], 401);
    }

    /**
     * GET Time claims for current user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function time(Request $request)
    {
        $claims = Claim::where('user', Auth::id())->whereHas('claimForm', function($query){
            $query->where('name', 'like','%Time Claim%');
        })->with("claimStatus", "claimUser", "claimForm")->get();

        if (Route::current()->getName() == 'api.myclaims.time')
        {
            return response()->json(["status" => "OK", "data" => ["timeclaims" => $claims]], 200);
        }
        return response()->json(["status" => "Error", "message" => "Something went wrong!"], 401);
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
        try{
            $claim = Claim::find($id);
            $claimStatus = ClaimStatus::where('state', 'like', $request->status)->first();
            $claim->status=$claimStatus->id;
            $claim->save();
            return response()->json(['status' => 'OK'], 200);
        }
        catch (Exception $e)
        {
            return response()->json(['status' => 'Fail', 'data'=>['reqStatus' => $request->status]], 201);
        }
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
        return response();
    }
}
