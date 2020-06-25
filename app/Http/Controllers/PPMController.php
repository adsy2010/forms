<?php

namespace App\Http\Controllers;

use App\PPM;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PPMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response
     */
    public function index()
    {
        //
        $ppm = PPM::with('mType')->orderBy('effectivePeriod', 'DESC')->get();
        return response()->json(['status' => 'ok', 'data' => $ppm]);
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
        $ppm = PPM::create([
            'mileageType' => $request->mileageType,
            'effectivePeriod' => $request->effectivePeriod,
            'amount' => $request->amount
        ]);
        $ppm->save();
        return response()->json(['status' => 'ok', 'data' => $ppm]);
    }

    /**
     * Display the specified resource.
     *
     * @param PPM $pPM
     * @return Response
     */
    public function show(PPM $pPM)
    {
        //
        return response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param PPM $pPM
     * @return Response
     */
    public function edit(PPM $pPM)
    {
        //
        return response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param PPM $ppm
     * @return JsonResponse|Response
     */
    public function update(Request $request, PPM $ppm)
    {
        //
        $ppm->effectivePeriod = $request->effectivePeriod;
        $ppm->amount = $request->amount;
        $ppm->save();
        return response()->json(['status' => 'ok', 'data' => $ppm]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PPM $ppm
     * @return JsonResponse|Response
     */
    public function destroy(PPM $ppm)
    {
        //TODO: add a check to make sure the period is not current or past
        $ppm->delete();
        return response()->json(['status' => 'ok']);
    }
}
