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
        return redirect('/cabinet');
        $student = new Student;
        $student->setCollectionFilter($request->input('fi'));
        $student->loadData();
        return view('dashboard.school.Student.list', compact('student'));
    }

    // public function scheduleFee()
    // {
    //     $student = new Student;
    //     return view('dashboard.school.Student.schedule-fee', compact('student'));
    // }

    // public function discount()
    // {
    //     $student = new Student;
    //     return view('dashboard.school.Student.discount', compact('student'));
    // }
}
