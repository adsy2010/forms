<?php

namespace App\Http\Controllers;

use App\Outcome;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OutcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        return response()->json(['status' => 'OK', 'data' => Outcome::all()]);
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
        //
        try {
            $outcome = Outcome::create([
                'claim' => $request->claim,
                'outcome' => $request->outcome
            ]);
            $outcome->save();
            return response()->json(['status' => 'OK', 'data' => $outcome]);
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
        return response();
    }
}
