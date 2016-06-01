<?php

namespace App\Http\Modules\Organization\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Organization\Models\Organization;
use App\Http\Modules\Organization\Requests\OrganizationFormRequest;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organization = new Organization;
        return view('modules.organization.Organization.list', compact('organization'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organization = new Organization;
        return view('modules.organization.Organization.form', compact('organization'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrganizationFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrganizationFormRequest $request)
    {
        $input = $request->input();
        $input['city_area'] = $request->input('city_area_new');
        $organization = new Organization($input);

        if ($organization->save()) {
            return redirect('/cabinet/organizations');
        }

        return redirect('/cabinet/organizations/create')->withErrors($organization->getErrors());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $organization = Organization::findOrFail($id);
        return view('modules.organization.Organization.form', compact('organization'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OrganizationFormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrganizationFormRequest $request, $id)
    {
        $input = $request->input();
        $input['city_area'] = $request->input('city_area_new');
        $input['organization_entity_id'] = $id;

        $organization = new Organization($input);

        if ($organization->update($request->input())) {
            return redirect('/cabinet/organizations');
        }

        return redirect(url('/cabinet/organizations/edit', compact('id')))
            ->withErrors($organization->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organization = Organization::findOrFail($id);

        if ($organization->delete()) {
            return redirect('/cabinet/organizations');
        }

        return redirect('/cabinet/organizations')->withErrors($organization->getErrors());
    }
}
