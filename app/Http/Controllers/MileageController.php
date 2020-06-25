<?php

namespace App\Http\Controllers;

use App\Claim;
use App\Mileage;
use App\PPM;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class MileageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response
     */
    public function index()
    {
        //
        return response()->json(["status" => "OK", "data" => Mileage::all()], 200);
    }

    public function showForClaim(Request $request)
    {
        return response()->json(["status" => "OK", "data" => Mileage::where('claim', $request->claim)->get()], 200);
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
     * @return JsonResponse|Response
     */
    public function store(Request $request)
    {
        //
        try{
            //TODO: Get the current ppm rate for the selected mileage type
            //TODO: Multiply the ppm rate by the mileage entered
            DB::beginTransaction();
            try{
                //Get the current claim
                if(!($claim = Claim::find($request->claim)))
                    throw new Exception('Unable to select the requested claim.');

                //Get the amount for PPM based on mileage type and claim period
                if(!($mileagePPM = $this->getPPM($request, $claim)))
                    throw new Exception('Unable to get PPM.');

                //Create a new line for mileage
                $mileage = Mileage::create([
                    'claim' => $request->claim,
                    'vehicle' => $request->vehicle,
                    'mileageType' => $request->mtype,
                    'mileageDate' => $request->date,
                    'mileageTime' => $request->time,
                    'mileage' => $request->amount,
                    'reason' => $request->reason,
                    'origin' => $request->from,
                    'destination' => $request->to,
                    'ppm' => $mileagePPM->amount,
                    'amount' => round($request->amount * $mileagePPM->amount, 2)
                ]);
                if(!$mileage->save())
                    throw new Exception('Couldnt save mileage');
            }
            catch(Exception $exception)
            {
                DB::rollBack();
                return response()->json(['status' => 'Failed', 'errors' => $exception->getMessage()], 400);
            }
            DB::commit();

            return response()->json(["status" => "OK", "data" => ["requestId" => $mileage->id]], 200);
        }
        catch(Exception $e)
        {
            return response()->json(["status" => "Server Error", "data"=> ["message" => $e->getMessage()]], 500);
        }
    }

    /**
     * @param Request $request
     * @param Claim $claim
     * @return mixed
     */
    private function getPPM(Request $request, Claim $claim)
    {
         return PPM::select('amount')
            ->where([
                ['mileageType','=', $request->mtype],
                ['effectivePeriod', '<=', $claim->period]
            ])
            ->orderBy('effectivePeriod', 'DESC')
            ->first();
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
     * @param  int  $id
     * @return JsonResponse|Response
     */
    public function update(Request $request, $id)
    {
        //
        DB::beginTransaction();
        try{
            //Get the current claim
            if(!($claim = Claim::find($request->claim)))
                throw new Exception('Unable to select the requested claim.');

            //Get the amount for PPM based on mileage type and claim period
            if(!($mileagePPM = $this->getPPM($request, $claim)))
                throw new Exception('Unable to get PPM.');

            $mileage = Mileage::findOrFail($id);
            $mileage->claim = $request->claim;
            $mileage->vehicle = $request->vehicle;
            $mileage->mileageType  = $request->mtype;
            $mileage->mileageDate = $request->date;
            $mileage->mileageTime = $request->time;
            $mileage->mileage = $request->amount;
            $mileage->reason = $request->reason;
            $mileage->origin = $request->from;
            $mileage->destination = $request->to;
            $mileage->ppm = $mileagePPM->amount;
            $mileage->amount = round($request->amount * $mileagePPM->amount, 2);
            $mileage->save();


        }
        catch(Exception $e)
        {
            DB::rollBack();
            return response()->json(["status" => "Server Error", "data" => ["message" => $e->getMessage()]], 500);
        }
        DB::commit();
        return response()->json(["status" => "OK", "data" => ["requestId" => $mileage->id]], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Mileage $id
     * @return JsonResponse|Response
     */
    public function destroy(Mileage $id)
    {
        //
        DB::beginTransaction();
        try{
            $id->delete();
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return response()->json(['status' => 'failed', 'error' => $exception->getMessage()], 400);
        }
        DB::commit();
        return  response()->json(['status' => 'ok'], 200);
    }
}
