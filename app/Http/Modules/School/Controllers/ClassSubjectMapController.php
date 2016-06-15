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
     * @param  int $classId
     * @param  int $subjectId
     * @return \Illuminate\Http\Response
     */
    public function map($classId, $subjectId)
    {
        $subject = new ClassSubjectMap;
        $subject->setAttribute('class_entity_id', $classId);
        $subject->setAttribute('subject_entity_id', $subjectId);
        $subject->map();
        flash('Subject Mapped!');
        return redirect('/cabinet/class-subject-map');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $classId
     * @param  int $subjectId
     * @return \Illuminate\Http\Response
     */
    public function destroy($classId, $subjectId)
    {
        // $subject = ClassSubjectMap::findOrFail($id);
        $subject = new ClassSubjectMap;
        $subject->setAttribute('class_entity_id', $classId);
        $subject->setAttribute('subject_entity_id', $subjectId);
        $subject->delete();
        flash('Subject Map Deleted!');
        return redirect('/cabinet/class-subject-map');
    }
}
