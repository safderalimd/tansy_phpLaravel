<?php

namespace App\Http\Modules\reports\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\reports\School\Models\FinalProgress;
use App\Http\PdfGenerator\Pdf;

class FinalProgressController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:'.FinalProgress::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $export = new FinalProgress;
        return view('reports.school.FinalProgress.list', compact('export'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        $export = new FinalProgress($request->input());
        $export->loadPdfData();
        $view = view('reports.school.FinalProgress.pdf', compact('export'));
        return Pdf::render($view);
    }
}
