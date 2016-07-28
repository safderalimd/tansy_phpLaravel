<?php

namespace App\Http\Modules\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\School\Models\Admission;
use App\Http\Modules\School\Requests\AdmissionFormRequest;
use App\Http\Modules\School\Requests\AdmissionMoveStudentsFormRequest;
use App\Http\Models\Grid;

class AdmissionController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . Admission::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $grid = new Grid('/' . $request->path());
        $grid->fill($request->input());
        $grid->loadData();

        $options = [
            'headerFirstInclude' => 'modules.school.Admission.header-first-include',
            'rowFirstInclude'    => 'modules.school.Admission.row-first-include',
            'afterGridInclude'   => 'modules.school.Admission.after-grid-include',
            'scriptsInclude'     => 'modules.school.Admission.scripts-include',
        ];

        return view('grid.list', compact('grid', 'options'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $admission = new Admission;
        $admission->loadDetail();
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
        flash('Admission Added!');
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
        $admission = new Admission;
        $admission->setAttribute('admission_id', $id);
        $admission->loadDetail();
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

        $admission = new Admission;
        $admission->setAttribute('admission_id', $id);
        $admission->loadDetail();
        $admission->update($input);
        flash('Admission Updated!');
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
        $admission = new Admission;
        $admission->setAttribute('admission_id', $id);
        $admission->delete();
        flash('Admission Deleted!');
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
        flash('Students Moved!');
        return redirect('/cabinet/admission');
    }
}
