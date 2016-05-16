<?php

namespace App\Http\Modules\School\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\School\Models\ExamSchedule;
use App\Http\Modules\School\Requests\ProductFormRequest;

class ExamScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedule = new ExamSchedule;
        return view('modules.school.ExamSchedule.list', compact('schedule'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $schedule = new ExamSchedule;
        return view('modules.school.ExamSchedule.form', compact('schedule'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductFormRequest $request)
    {
        $schedule = new ExamSchedule($request->input());

        if ($schedule->save()) {
            return redirect('/cabinet/exam-schedule');
        }

        return redirect('/cabinet/exam-schedule/create')->withErrors($schedule->getErrors());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $schedule = ExamSchedule::findOrFail($id);
        return view('modules.school.ExamSchedule.form', compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductFormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductFormRequest $request, $id)
    {
        $schedule = ExamSchedule::findOrFail($id);

        if ($schedule->update($request->input())) {
            return redirect('/cabinet/exam-schedule');
        }

        return redirect(url('/cabinet/exam-schedule/edit', compact('id')))
            ->withErrors($schedule->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schedule = ExamSchedule::findOrFail($id);

        if ($schedule->delete()) {
            return redirect('/cabinet/exam-schedule');
        }

        return redirect('/cabinet/exam-schedule')->withErrors($schedule->getErrors());
    }
}
