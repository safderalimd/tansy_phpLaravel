<?php

namespace App\Http\Modules\dashboard\school\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\dashboard\school\Models\Exam;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $exam = new Exam;
        $exam->setAttribute('exam_entity_id', $request->input('eei'));
        $exam->setAttribute('class_entity_id', $request->input('cei'));
        $exam->loadData();
        return view('dashboard.school.Exam.list', compact('exam'));
    }

    public function toppers(Request $request)
    {
        $exam = new Exam;
        $exam->setAttribute('exam_entity_id', $request->input('eei'));
        return view('dashboard.school.Exam.toppers', compact('exam'));
    }

    public function failedStudents(Request $request)
    {
        $exam = new Exam;
        $exam->setAttribute('exam_entity_id', $request->input('eei'));
        d($exam->failedStudents());
        // return view('dashboard.school.Exam.failed-students', compact('exam'));
    }

    public function absentees(Request $request)
    {
        $exam = new Exam;
        $exam->setAttribute('exam_entity_id', $request->input('eei'));
        return view('dashboard.school.Exam.absentees', compact('exam'));
    }
}
