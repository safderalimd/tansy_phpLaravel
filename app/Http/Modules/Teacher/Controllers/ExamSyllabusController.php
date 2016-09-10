<?php

namespace App\Http\Modules\Teacher\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Teacher\Models\ExamSyllabus;

class ExamSyllabusController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . ExamSyllabus::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $syllabus = new ExamSyllabus($request->input());
        return view('modules.teacher.ExamSyllabus.list', compact('syllabus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $syllabus = ExamSyllabus::find($id);
        return view('modules.teacher.ExamSyllabus.form', compact('syllabus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $syllabus = new ExamSyllabus($request->input());
        $syllabus->setAttribute('exam_schedule_id', $id);
        $syllabus->update();
        flash('Exam Syllabus Updated!');
        return redirect('/cabinet/exam-syllabus'.query_string());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $syllabus = new ExamSyllabus;
        $syllabus->setAttribute('exam_schedule_id', $id);
        $syllabus->delete();
        flash('Exam Syllabus Deleted!');
        return redirect('/cabinet/exam-syllabus'.query_string());
    }
}
