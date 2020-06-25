<?php

namespace App\Http\Controllers;

use App\Parking;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ParkingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        //
        return response()->json(["status" => "OK", "data" => Parking::all()], 200);
    }

    public function showForClaim(Request $request)
    {
        return response()->json(["status" => "OK", "data" => Parking::where('claim', $request->claim)->get()], 200);
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

            $parking = Parking::create([
                'claim' => 1,
                'parkingDate' => $request->date,
                'amount' => $request->amount
            ]);
            $parking->save();

            return response()->json(["status" => "OK", "data" => ["requestId" => $parking->id]], 200);
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
        $parking = Parking::findOrFail($id);
        try{
            $parking->claim = 1;
            $parking->parkingDate = $request->date;
            $parking->amount = $request->amount;
            $parking->save();

            return response()->json(["status" => "OK", "data" => ["requestId" => $parking->id]], 200);
        }
        catch(Exception $e)
        {
            return response()->json(["status" => "Server Error", "data"=> ["message" => $e->getMessage()]], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
        Parking::destroy($id);
        return  response(null, 200);
    }
}
