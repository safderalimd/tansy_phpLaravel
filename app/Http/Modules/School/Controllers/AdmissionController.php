<?php

namespace App\Http\Modules\School\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\School\Models\Admission;
use App\Http\Modules\School\Requests\AdmissionFormRequest;
use App\Http\Modules\School\Requests\AdmissionMoveStudentsFormRequest;

class AdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admission = new Admission;
        return view('modules.school.Admission.list', compact('admission'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $admission = new Admission;
        return view('modules.school.Admission.form', compact('admission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdmissionFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdmissionFormRequest $request)
    {
        $input = $request->input();
        $cityAreaNew = $request->input('city_area_new');
        $input['city_area'] = $cityAreaNew;

        $admission = new Admission($input);
        $admission->save();
        return redirect('/cabinet/admission');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admission = Admission::findOrFail($id);
        return view('modules.school.Admission.form', compact('admission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdmissionFormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdmissionFormRequest $request, $id)
    {
        $input = $request->input();
        $cityAreaNew = $request->input('city_area_new');
        $input['city_area'] = $cityAreaNew;

        $admission = Admission::findOrFail($id);
        $admission->fill($input);
        $admission->update($input);
        return redirect('/cabinet/admission');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admission = Admission::findOrFail($id);
        $admission->delete();
        return redirect('/cabinet/admission');
    }

    /**
     * Schedule selected rows.
     *
     * @param AdmissionMoveStudentsFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function moveStudents(AdmissionMoveStudentsFormRequest $request)
    {
        $admission = new Admission($request->input());
        $admission->moveStudents();
        return redirect('/cabinet/admission');
    }
}
