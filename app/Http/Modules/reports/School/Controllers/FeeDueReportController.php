<?php

namespace App\Http\Modules\reports\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\reports\School\Models\FeeDueReport;
use App\Http\Modules\reports\School\Requests\FeeDueReportFormRequest;
use App\Http\PdfGenerator\Pdf;

class FeeDueReportController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:'.FeeDueReport::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $report = new FeeDueReport;
        return view('reports.school.FeeDueReport.list', compact('report'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  FeeDueReportFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function report(FeeDueReportFormRequest $request)
    {
        $export = new FeeDueReport($request->input());
        $export->loadPdfData();
        $view = view('reports.school.FeeDueReport.pdf', compact('export'));
        return Pdf::render($view);
    }

}
