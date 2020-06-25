<?php

namespace App\Http\Controllers;

use App\MileageType;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class MileageTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Factory|JsonResponse|Response|View
     */
    public function index(Request $request)
    {
        //
        if (Route::current()->getName() == 'mileagetype.index')
        {
            return response()->json(["status" => "OK", "data" => MileageType::all()], 200);
        }
        return view('v2.MileageTypes.index', ['mileageTypes' => MileageType::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|Response|View
     */
    public function create()
    {
        //
        return view('v2.MileageTypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function store(Request $request)
    {
        //
        $mileageType = new MileageType();
        $mileageType->name = $request->name;
        $mileageType->save();
        return redirect()->to(Route('MileageType.create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
        return MileageType::findOrFail($id);
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
        $transportType = MileageType::find($id);
        $transportType->name = $request->name;
        $transportType->save();
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
        $transportType = MileageType::find($id);
        $transportType->delete();
        return response();
    }
}
