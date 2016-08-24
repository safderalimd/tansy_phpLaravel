<?php

namespace App\Http\Modules\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\School\Models\ProgressGrade;
use App\Http\Modules\School\Requests\ProgressGradeFormRequest;

class ProgressGradeController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . ProgressGrade::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $progress = new ProgressGrade($request->input());
        return view('modules.school.ProgressGrade.list', compact('progress'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $progress = new ProgressGrade;
        return view('modules.school.ProgressGrade.form', compact('progress'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProgressGradeFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProgressGradeFormRequest $request)
    {
        $progress = new ProgressGrade($request->input());
        $progress->save();
        flash('Event Added!');
        return redirect('/cabinet/progress-grade'.query_string());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $progress = new ProgressGrade;
        $progress->setDetail($id);
        return view('modules.school.ProgressGrade.form', compact('progress'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProgressGradeFormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProgressGradeFormRequest $request, $id)
    {
        $progress = new ProgressGrade($request->input());
        $progress->setAttribute('event_id', $id);
        $progress->update();
        flash('Event Updated!');
        return redirect('/cabinet/progress-grade'.query_string());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $progress = new ProgressGrade($request->input());
        $progress->setAttribute('event_id', $id);
        $progress->delete();
        flash('Event Deleted!');
        return redirect('/cabinet/progress-grade'.query_string());
    }
}
