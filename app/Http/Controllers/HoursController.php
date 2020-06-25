<?php

namespace App\Http\Controllers;

use App\Hours;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HoursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response
     */
    public function index()
    {
        //
        return response()->json(["status"=>"OK", "data" => Hours::all()], 200);
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
        // This method must create an item for EVERY day in the month for a specific claim ID
        // $request->period should be in format YYYY-MM
        // $request->claim
        try{
            $days = Carbon::createFromFormat('Ym', $request->period)->daysInMonth;
            for($x = 1; $x <=$days; $x++)
            {
                $hours = Hours::create([
                    "claim" => $request->claim,
                    "claimDate" => Carbon::createFromFormat('Ymd', $request->period.$x)->toDateString(),
                    "hours" => 0
                ]);
                $hours->save();
            }
            return response()->json(["status" => "OK", "data"=> ["daysCreated" => $days]]);
        }
        catch(Exception $e)
        {
            return response()->json(["status" => "Server Error", "data"=> ["message" => $e->getMessage()]], 500);
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
        $claimItem = Hours::where('claim', $id)->get();
        return response()->json(['status' => 'OK', "data" => $claimItem], 200);
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
        //return response()->json(['status' => 'ok', 'data'=>$id], 200);

        try{
            //$hours = Hours::where('claim', $id)->get();
            //$hours->claim = 1;
            //$hours->claimDate = $request->date;
            foreach($request->data as $hours){
                $hour = Hours::find($hours['id']);
                $hour->hours = (double)$hours['hours'];
                $hour->save();
            }

            return response()->json(["status" => "OK"], 200);
        }
        catch(Exception $e)
        {
            return response()->json(["status" => "Server Error", "data"=> ["message" => $e->getMessage()]], 501);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse|Response
     */
    public function destroy($id)
    {
        //
        try{
            Hours::destroy($id);
            return response(null, 200);
        }
        catch(Exception $e)
        {
            return response()->json(["status" => "Server Error", "data"=> ["message" => $e->getMessage()]], 500);
        }

    }
}
