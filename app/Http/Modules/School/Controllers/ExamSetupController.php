<?php

namespace App\Http\Modules\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\School\Models\ExamSetup;
// use App\Http\Modules\School\Requests\ExamFormRequest;

class ExamSetupController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . ExamSetup::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $setup = new ExamSetup($request->input());
        return view('modules.school.ExamSetup.list', compact('setup'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $setup = new ExamSetup;
        return view('modules.school.ExamSetup.form', compact('setup'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ExamFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExamFormRequest $request)
    {
        $setup = new ExamSetup;
        $setup->setAttribute('active', 0);
        $setup->fill($request->input());
        $setup->setCheckboxes();
        $setup->save();
        flash('Exam Added!');
        return redirect('/cabinet/exam');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $setup = new ExamSetup;
        $setup->setDetail($id);
        $setup->loadData();
        return view('modules.school.ExamSetup.form', compact('setup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ExamFormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExamFormRequest $request, $id)
    {
        $setup = new ExamSetup;
        $setup->setAttribute('active', 0);
        $setup->setAttribute('exam_entity_id', $id);
        $setup->fill($request->input());
        $setup->setCheckboxes();
        $setup->update();
        flash('Exam Updated!');
        return redirect('/cabinet/exam');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $setup = new ExamSetup;
        $setup->setAttribute('exam_entity_id', $id);
        $setup->delete();
        flash('Exam Deleted!');
        return redirect('/cabinet/exam');
    }
}
