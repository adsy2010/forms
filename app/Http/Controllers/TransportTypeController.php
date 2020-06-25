<?php

namespace App\Http\Controllers;

use App\TransportType;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class TransportTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|JsonResponse|Response|View
     */
    public function index()
    {
        //List transport types
        if (Route::current()->getName() == 'transporttype.index')
        {
            return response()->json(["status" => "OK", "data" => TransportType::all()], 200);
        }
        return view('v2.TransportTypes.index', ['transportTypes' => TransportType::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|Response|View
     */
    public function create()
    {
        //
        return view('v2.TransportTypes.create');
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
        $transportType = new TransportType();
        $transportType->name = $request->name;
        $transportType->save();
        return redirect()->to(Route('TransportType.create'));
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
        return TransportType::findOrFail($id);
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
        $transportType = TransportType::find($id);
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
        $transportType = TransportType::find($id);
        $transportType->delete();
        return response();
    }
}