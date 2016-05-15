<?php

namespace App\Http\Modules\School\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Modules\School\Models\ClassSubjectMap;
use App\Http\Modules\School\Requests\ClassSubjectMapFormRequest;

class ClassSubjectMapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = new ClassSubjectMap;
        return view('modules.school.ClassSubjectMap.list', compact('subjects'));
    }

    /**
     * Map school class subject.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function map($id)
    {
        $subject = ClassSubjectMap::findOrFail($id);

        if ($subject->map()) {
            return redirect('/cabinet/class-subject-map');
        }

        return redirect('/cabinet/class-subject-map')->withErrors($subject->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = ClassSubjectMap::findOrFail($id);

        if ($subject->delete()) {
            return redirect('/cabinet/class-subject-map');
        }

        return redirect('/cabinet/class-subject-map')->withErrors($subject->getErrors());
    }
}
