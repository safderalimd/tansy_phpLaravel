<?php

namespace App\Http\Modules\reports\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\reports\School\Models\ProgressPrintStudent;
use App\Http\FPDF\ProgressPrintStudent\V1PDF;
use Device;

class ProgressPrintStudentController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        V1PDF::portrait()->generate(null, null);

        $this->middleware('screen:' . ProgressPrintStudent::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $progress = new ProgressPrintStudent;
        return view('reports.school.ProgressPrintStudent.list', compact('progress'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        $export = new ProgressPrintStudent;
        $export->setAttribute('exam_entity_id', $request->input('ei'));
        $export->setAttribute('filter_entity_id', $request->input('ci'));
        $export->setAttribute('class_student_id', 0);
        $export->setAttribute('return_type', 'Student Report');
        $progress = $export->getPdfData();

        if (Device::isAndroidMobile()) {
            return view('reports.school.ProgressPrintStudent.pdf', compact('export', 'progress'));
        } else {
            V1PDF::portrait()->generate($export, $progress);
        }
    }
}
