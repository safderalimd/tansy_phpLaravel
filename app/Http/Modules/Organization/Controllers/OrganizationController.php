<?php

namespace App\Http\Modules\Organization\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Organization\Models\Organization;
use App\Http\Modules\Organization\Requests\OrganizationFormRequest;

class OrganizationController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . Organization::screenId());
    }

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
        return view('modules.organization.Organization.new-record', compact('organization'));
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
        $input['facility_city_area'] = $request->input('facility_city_area_new');

        $organization = new Organization($input);
        $organization->setFacilityNewFlag();
        $organization->save();
        flash('Organization Added!');
        return redirect('/cabinet/organizations');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $organization = Organization::find($id);
        return view('modules.organization.Organization.edit-form', compact('organization'));
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
        $organization->update();
        flash('Organization Updated!');
        return redirect('/cabinet/organizations');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organization = Organization::find($id);
        $organization->delete();
        flash('Organization Deleted!');
        return redirect('/cabinet/organizations');
    }
}
