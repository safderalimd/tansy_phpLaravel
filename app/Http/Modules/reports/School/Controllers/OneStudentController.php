<?php

namespace App\Http\Modules\reports\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\reports\School\Models\OneStudent;
use App\Http\FPDF\OneStudent\OneStudentPDF;
use Device;

class OneStudentController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . OneStudent::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $export = new OneStudent;
        return view('reports.school.OneStudent.list', compact('export'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        $export = new OneStudent($request->input());
        $export->loadPdfData();

        if (Device::isAndroidMobile()) {
            return view('reports.school.OneStudent.pdf', compact('export'));
        } else {
            OneStudentPDF::portrait()->generate($export);
        }
    }
}
