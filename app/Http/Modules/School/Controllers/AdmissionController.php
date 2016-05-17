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
        $admission = new Admission($request->input());

        if ($admission->save()) {
            return redirect('/cabinet/admission');
        }

        return redirect('/cabinet/admission/create')->withErrors($admission->getErrors());
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
        $admission = Admission::findOrFail($id);

        if ($admission->update($request->input())) {
            return redirect('/cabinet/admission');
        }

        return redirect(url('/cabinet/admission/edit', compact('id')))
            ->withErrors($admission->getErrors());
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

        if ($admission->delete()) {
            return redirect('/cabinet/admission');
        }

        return redirect('/cabinet/admission')->withErrors($admission->getErrors());
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

        if ($admission->moveStudents()) {
            return redirect('/cabinet/admission');
        }

        return redirect('/cabinet/admission')->withErrors($admission->getErrors());
    }
}
