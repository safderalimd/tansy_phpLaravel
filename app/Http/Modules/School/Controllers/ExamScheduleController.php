<?php

namespace App\Http\Modules\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\School\Models\ExamSchedule;
use App\Http\Modules\School\Requests\ExamScheduleMapSubjectsFormRequest;
use App\Http\Modules\School\Requests\ExamScheduleRowsFormRequest;
use App\Http\Modules\School\Requests\ExamScheduleDeleteFormRequest;

class ExamScheduleController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . ExamSchedule::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $schedule = new ExamSchedule($request->input());
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
        $schedule->mapSubjects();
        flash('Subjects Mapped!');
        return redirect_back();
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
        $schedule->scheduleRows();
        flash('Exam Scheduled!');
        return redirect_back();
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
        $schedule->delete();
        flash('Exam Deleted!');
        return redirect('/cabinet/exam-schedule?eid='.$request->input('eid'));
    }
}
