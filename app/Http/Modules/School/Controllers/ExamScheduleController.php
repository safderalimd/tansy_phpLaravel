<?php

namespace App\Http\Modules\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\School\Models\ExamSchedule;
use App\Http\Modules\School\Requests\ExamScheduleMapSubjectsFormRequest;
use App\Http\Modules\School\Requests\ExamScheduleRowsFormRequest;
use App\Http\Models\Grid;

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
        $grid = new Grid('/' . $request->path());
        $grid->fill($request->input());
        $grid->loadData();

        $schedule = new ExamSchedule($request->input());

        $options = [
            'headerFirstInclude' => 'modules.school.ExamSchedule.header-first-include',
            'rowFirstInclude'    => 'modules.school.ExamSchedule.row-first-include',
            // 'headerLastInclude'  => 'modules.school.ExamSchedule.header-last-include',
            // 'rowLastInclude'     => 'modules.school.ExamSchedule.row-last-include',
            'beforeGridInclude'  => 'modules.school.ExamSchedule.before-grid-include',
            'afterGridInclude'   => 'modules.school.ExamSchedule.after-grid-include',
            'scriptsInclude'     => 'modules.school.ExamSchedule.scripts-include',
            'skipGridFilters'    => true,
        ];

        return view('grid.list', compact('grid', 'options', 'schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $schedule = new ExamSchedule($request->input());
        $schedule->setDetail($id);
        return view('modules.school.ExamSchedule.form', compact('schedule'));
    }

    public function update(Request $request, $id)
    {
        $product = new ExamSchedule;
        $product->setAttribute('exam_schedule_id', $id);
        $product->update($request->input());
        flash('Exam Schedule Updated!');
        return redirect('/cabinet/exam-schedule?f1='.$request->input('f1'));
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

    public function paper2(Request $request)
    {
        $schedule = new ExamSchedule($request->input());
        $schedule->paper2();
        flash('Paper 2 Created!');
        return redirect('/cabinet/exam-schedule?f1='.$request->input('f1'));
    }

    public function destroy(Request $request)
    {
        $schedule = new ExamSchedule($request->input());
        $schedule->delete();
        flash('Exam Schedule Deleted!');
        return redirect('/cabinet/exam-schedule?f1='.$request->input('f1'));
    }
}
