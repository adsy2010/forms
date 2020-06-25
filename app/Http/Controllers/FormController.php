<?php

namespace App\Http\Controllers;

use App\Form;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|JsonResponse|Response|View
     */
    public function index()
    {
        //
        if (Route::current()->getName() == 'form.index')
        {
            return response()->json(["status" => "OK", "data" => Form::with('authGroups', 'authGroups.groupData')->get()], 200);
        }
        return view('v2.Form.index', ['forms' => Form::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|Response|View
     */
    public function create()
    {
        //
        return view('v2.Form.create');
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
        $form = new Form();
        $form->name = $request->name;
        $form->isClaim = $request->isClaim;
        $form->save();
        return redirect()->to(Route('Form.create'));
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
        return Form::findOrFail($id);
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
        $form = Form::find($id);
        $form->name = $request->name;
        $form->isClaim = $request->isClaim;
        $form->save();
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
        $form = Form::find($id);
        $form->delete();
        return response();
    }
}
