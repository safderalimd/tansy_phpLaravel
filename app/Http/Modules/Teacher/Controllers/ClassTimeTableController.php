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
        return view('modules.teacher.ClassTimeTable.list', compact('timetable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $timetable = new ClassTimeTable;
        return view('modules.teacher.ClassTimeTable.form', compact('timetable'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $timetable = new ClassTimeTable($request->input());
        $timetable->save();
        flash('ClassTimeTable Added!');
        return redirect('/cabinet/class-time-table'.query_string());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $timetable = ClassTimeTable::find($id);
        return view('modules.teacher.ClassTimeTable.form', compact('timetable'));
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
        $timetable = new ClassTimeTable($request->input());
        $timetable->setAttribute('home_work_id', $id);
        $timetable->update();
        flash('ClassTimeTable Updated!');
        return redirect('/cabinet/class-time-table'.query_string());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $timetable = new ClassTimeTable;
        $timetable->setAttribute('home_work_id', $id);
        $timetable->delete();
        flash('ClassTimeTable Deleted!');
        return redirect('/cabinet/class-time-table'.query_string());
    }
}
