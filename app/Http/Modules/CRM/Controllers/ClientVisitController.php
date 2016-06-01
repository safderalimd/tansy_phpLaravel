<?php

namespace App\Http\Modules\CRM\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\CRM\Models\ClientVisit;
use App\Http\Modules\CRM\Requests\ClientVisitFormRequest;

class ClientVisitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = new ClientVisit;
        return view('modules.crm.ClientVisit.list', compact('client'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client = new ClientVisit;
        return view('modules.crm.ClientVisit.form', compact('client'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ClientVisitFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientVisitFormRequest $request)
    {
        $client = new ClientVisit($request->input());

        if ($client->save()) {
            return redirect('/cabinet/client-visit');
        }

        return redirect('/cabinet/client-visit/create')->withErrors($client->getErrors());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = ClientVisit::findOrFail($id);
        return view('modules.crm.ClientVisit.form', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ClientVisitFormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientVisitFormRequest $request, $id)
    {
        $client = ClientVisit::findOrFail($id);

        if ($client->update($request->input())) {
            return redirect('/cabinet/client-visit');
        }

        return redirect(url('/cabinet/client-visit/edit', compact('id')))
            ->withErrors($client->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = ClientVisit::findOrFail($id);

        if ($client->delete()) {
            return redirect('/cabinet/client-visit');
        }

        return redirect('/cabinet/client-visit')->withErrors($client->getErrors());
    }
}
