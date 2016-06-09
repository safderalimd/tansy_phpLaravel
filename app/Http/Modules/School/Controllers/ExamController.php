<?php

namespace App\Http\Modules\School\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\School\Models\Exam;
use App\Http\Modules\School\Requests\ExamFormRequest;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exam = new Exam;
        return view('modules.school.Exam.list', compact('exam'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $exam = new Exam;
        return view('modules.school.Exam.form', compact('exam'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ExamFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExamFormRequest $request)
    {
        $exam = new Exam($request->input());
        $exam->save();
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
        $exam = Exam::findOrFail($id);
        return view('modules.school.Exam.form', compact('exam'));
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
        $exam = new Exam($request->input());
        $exam->setAttribute('exam_entity_id', $id);
        $exam->update();
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
        $exam = Exam::findOrFail($id);
        $exam->delete();
        flash('Exam Deleted!');
        return redirect('/cabinet/exam');
    }
}
