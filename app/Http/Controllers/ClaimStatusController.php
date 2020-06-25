<?php

namespace App\Http\Controllers;

use App\ClaimStatus;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class ClaimStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|JsonResponse|Response|View
     */
    public function index()
    {
        //
        if (Route::current()->getName() == 'claimstatus.index')
        {
            return response()->json(["status" => "OK", "data" => ClaimStatus::all()], 200);
        }
        return view('v2.ClaimStatuses.index', ['claimStatuses' => ClaimStatus::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|Response|View
     */
    public function create()
    {
        //
        return view('v2.ClaimStatuses.create');
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
        $claimStatus = new ClaimStatus();
        $claimStatus->state = $request->name;
        $claimStatus->save();
        return redirect()->to(Route('ClaimStatus.create'));
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
        return ClaimStatus::findOrFail($id);
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
        $claimStatus = ClaimStatus::find($id);
        $claimStatus->name = $request->name;
        $claimStatus->save();
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
        $claimStatus = ClaimStatus::find($id);
        $claimStatus->delete();
        return response();
    }
}
