<?php

namespace App\Http\Modules\School\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\School\Models\Subject;
use App\Http\Modules\School\Requests\SubjectFormRequest;

class SubjectController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . Subject::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subject = new Subject;
        return view('modules.school.Subject.list', compact('subject'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subject = new Subject;
        return view('modules.school.Subject.form', compact('subject'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SubjectFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubjectFormRequest $request)
    {
        $subject = new Subject;
        $subject->setAttribute('active', 0);
        $subject->save($request->input());
        flash('Subject Added!');
        return redirect('/cabinet/subject');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->loadData();
        return view('modules.school.Subject.form', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SubjectFormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubjectFormRequest $request, $id)
    {
        $subject = new Subject;
        $subject->setAttribute('active', 0);
        $subject->setAttribute('subject_entity_id', $id);
        $subject->update($request->input());
        flash('Subject Updated!');
        return redirect('/cabinet/subject');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();
        flash('Subject Deleted!');
        return redirect('/cabinet/subject');
    }
}
