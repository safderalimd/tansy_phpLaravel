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
        $setup = new ExamSetup($request->input());
        $setup->setAttribute('exam_entity_id', $request->input('eei'));
        $setup->save();
        flash('Exam Setup Added!');
        return redirect('/cabinet/exam-setup?eei='.$request->input('eei'));
    }

    public function edit(Request $request, $id)
    {
        $setup = new ExamSetup($request->input());
        $setup->setDetail($id);
        return view('modules.school.ExamSetup.form', compact('setup'));
    }

    public function update(Request $request, $id)
    {
        $product = new ExamSetup;
        $product->setAttribute('exam_schedule_id', $id);
        $product->update($request->input());
        flash('Exam Setup Updated!');
        return redirect('/cabinet/exam-setup?eei='.$request->input('eei'));
    }

    public function destroy(Request $request)
    {
        $setup = new ExamSetup($request->input());
        $setup->delete();
        flash('Exam Setup Deleted!');
        return redirect('/cabinet/exam-setup?eei='.$request->input('eei'));
    }

    public function copy(Request $request)
    {
        $setup = new ExamSetup($request->input());
        $setup->copy();
        flash('Exam Copied!');
        return redirect('/cabinet/exam-setup?eei='.$request->input('eei'));
    }
}
