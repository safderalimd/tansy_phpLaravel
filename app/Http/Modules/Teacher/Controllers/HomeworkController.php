<?php

namespace App\Http\Modules\Teacher\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Teacher\Models\Homework;

class HomeworkController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . Homework::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $homework = new Homework($request->input());
        return view('modules.teacher.Homework.list', compact('homework'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $homework = new Homework;
        return view('modules.teacher.Homework.form', compact('homework'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $homework = new Homework($request->input());
        $homework->save();
        flash('Homework Added!');
        return redirect('/cabinet/homework'.query_string());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $homework = Homework::find($id);
        return view('modules.teacher.Homework.form', compact('homework'));
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
        $homework = new Homework($request->input());
        $homework->setAttribute('home_work_id', $id);
        $homework->update();
        flash('Homework Updated!');
        return redirect('/cabinet/homework'.query_string());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $homework = new Homework;
        $homework->setAttribute('home_work_id', $id);
        $homework->delete();
        flash('Homework Deleted!');
        return redirect('/cabinet/homework'.query_string());
    }
}
