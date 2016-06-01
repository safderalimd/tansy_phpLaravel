<?php

namespace App\Http\Modules\School\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\School\Models\Attendance;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd('-');
        $attendance = new Attendance;
        return view('modules.school.Attendance.list', compact('attendance'));
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Req $request, $id)
    // {
    //     // $attendance = Attendance::findOrFail($id);

    //     // if ($attendance->update($request->input())) {
    //     //     return redirect('/cabinet/attendance');
    //     // }

    //     // return redirect(url('/cabinet/product/edit', compact('id')))
    //     //     ->withErrors($product->getErrors());
    // }
}
