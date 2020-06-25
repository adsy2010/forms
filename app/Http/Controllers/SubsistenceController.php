<?php

namespace App\Http\Controllers;

use App\Subsistence;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubsistenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response
     */
    public function index()
    {
        //
        return response()->json(["status" => "OK", "data" => Subsistence::all()], 200);
    }

    public function showForClaim(Request $request)
    {
        return response()->json(["status" => "OK", "data" => Subsistence::where('claim', $request->claim)->get()], 200);
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

            $subsistence = Subsistence::create([
                'claim' => 1,
                'subsistenceDate' => $request->date,
                'amount' => $request->amount
            ]);
            $subsistence->save();

            return response()->json(["status" => "OK", "data" => ["requestId" => $subsistence->id]], 200);
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
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
        Subsistence::destroy($id);
        return  response(null, 200);
    }
}
