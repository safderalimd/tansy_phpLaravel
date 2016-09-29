<?php

namespace App\Http\Modules\Teacher\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Teacher\Models\MonthlyAttendance;

class MonthlyAttendanceController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . MonthlyAttendance::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $attendance = new MonthlyAttendance($request->input());
        return view('modules.teacher.MonthlyAttendance.list', compact('attendance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $timetable = new MonthlyAttendance($request->input());
        $timetable->update();
        flash('Absentees Updated!');
        return redirect('/cabinet/monthly-attendance'.query_string());
    }
}
