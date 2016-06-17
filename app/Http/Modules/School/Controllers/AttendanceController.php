<?php

namespace App\Http\Modules\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\School\Models\Attendance;

class AttendanceController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . Attendance::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $attendance = new Attendance($request->input());
        $attendance->loadData();
        return view('modules.school.Attendance.list', compact('attendance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $attendance = new Attendance;
        $attendance->update($request->input());
        flash('Attendance Updated!');
        return \Redirect::back();
    }
}
