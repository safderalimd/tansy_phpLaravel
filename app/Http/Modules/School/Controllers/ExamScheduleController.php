<?php

namespace App\Http\Modules\School\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\School\Models\ExamSchedule;
use App\Http\Modules\School\Requests\ExamScheduleMapSubjectsFormRequest;
use App\Http\Modules\School\Requests\ExamScheduleRowsFormRequest;
use App\Http\Modules\School\Requests\ExamScheduleDeleteFormRequest;

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
     * Map subjects.
     *
     * @param ExamScheduleMapSubjectsFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function mapSubjects(ExamScheduleMapSubjectsFormRequest $request)
    {
        $schedule = new ExamSchedule($request->input());

        if ($schedule->mapSubjects()) {
            return redirect('/cabinet/exam-schedule');
        }

        return redirect('/cabinet/exam-schedule')->withErrors($schedule->getErrors());
    }

    /**
     * Schedule selected rows.
     *
     * @param ExamScheduleRowsFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function scheduleRows(ExamScheduleRowsFormRequest $request)
    {
        $schedule = new ExamSchedule($request->input());

        if ($schedule->scheduleRows()) {
            return redirect('/cabinet/exam-schedule');
        }

        return redirect('/cabinet/exam-schedule')->withErrors($schedule->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     * Ids will be in the query string.
     *
     * @param ExamScheduleDeleteFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExamScheduleDeleteFormRequest $request)
    {
        $schedule = new ExamSchedule($request->input());

        if ($schedule->delete()) {
            return redirect('/cabinet/exam-schedule');
        }

        return redirect('/cabinet/exam-schedule')->withErrors($schedule->getErrors());
    }
}
