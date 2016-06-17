<?php

namespace App\Http\Modules\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\School\Models\SchoolClass;
use App\Http\Modules\School\Requests\SchoolClassFormRequest;
use App\Http\Modules\School\Repositories\SchoolClassRepository;

class SchoolClassController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . SchoolClass::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $class = new SchoolClass;
        return view('modules.school.SchoolClass.list', compact('class'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $class = new SchoolClass;
        return view('modules.school.SchoolClass.form', compact('class'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SchoolClassFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SchoolClassFormRequest $request)
    {
        $class = new SchoolClass($request->input());
        $class->save();
        flash('Class Added!');
        return redirect('/cabinet/class');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $class = SchoolClass::findOrFail($id);
        return view('modules.school.SchoolClass.form', compact('class'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SchoolClassFormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(SchoolClassFormRequest $request, $id)
    {
        $class = new SchoolClass;
        $class->setAttribute('class_entity_id', $id);
        $class->setAttribute('active', 0);
        $class->update($request->input());
        flash('Class Updated!');
        return redirect('/cabinet/class');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $class = SchoolClass::findOrFail($id);
        $class->delete();
        flash('Class Deleted!');
        return redirect('/cabinet/class');
    }
}
