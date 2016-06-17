<?php

namespace App\Http\Modules\reports\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\reports\School\Models\ProgressPrintClass;
use App\Http\PdfGenerator\Pdf;

class ProgressPrintClassController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:'.ProgressPrintClass::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $progress = new ProgressPrintClass;
        return view('reports.school.ProgressPrintClass.list', compact('progress'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        $export = new ProgressPrintClass;
        $export->setAttribute('exam_entity_id', $request->input('ei'));
        $export->setAttribute('class_entity_id', $request->input('ci'));
        $export->setAttribute('class_student_id', 0);
        $export->loadPdfData();
        $view = view('reports.school.ProgressPrintClass.pdf', compact('export'));
        return Pdf::renderLandscape($view);
    }
}
