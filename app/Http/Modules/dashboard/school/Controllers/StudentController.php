<?php

namespace App\Http\Modules\dashboard\school\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\dashboard\school\Models\Student;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $student = new Student;
        $student->setAttribute('class_student_id', $request->input('csi'));
        $student->setAttribute('student_entity_id', $request->input('sei'));
        $student->setAttribute('exam_entity_id', $request->input('eei'));

        $student->loadData();
        return view('dashboard.school.Student.list', compact('student'));
    }

    public function overallGrade(Request $request)
    {
        $student = new Student;
        $student->setAttribute('class_student_id', $request->input('csi'));
        return view('dashboard.school.Student.overall-grade', compact('student'));
    }

    public function feeDueDetails(Request $request)
    {
        $student = new Student;
        $student->setAttribute('student_entity_id', $request->input('sei'));
        return view('dashboard.school.Student.fee-due', compact('student'));
    }

    public function smsHistory(Request $request)
    {
        $student = new Student;
        $student->setAttribute('class_student_id', $request->input('csi'));
        return view('dashboard.school.Student.sms-history', compact('student'));
    }
}
