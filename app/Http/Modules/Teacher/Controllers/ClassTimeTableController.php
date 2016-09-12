<?php

namespace App\Http\Modules\Teacher\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Teacher\Models\ClassTimeTable;

class ClassTimeTableController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . ClassTimeTable::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $timetable = new ClassTimeTable($request->input());
        // d('weekDays');
        // d($timetable->weekDays());
        // d('periods');
        // d($timetable->periods());
        // d('classSubject');
        // d($timetable->classSubject());
        // d('classSubjectTeacher');
        // d($timetable->classSubjectTeacher());
        // d('rows');
        // d($timetable->rows());
        // d('teacher rows');
        // dd($timetable->teacherRows());
        return view('modules.teacher.ClassTimeTable.list', compact('timetable'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $timetable = new ClassTimeTable($request->input());
        $timetable->update();
        flash('Time Table Updated!');
        return redirect('/cabinet/class-time-table'.query_string());
    }
}
