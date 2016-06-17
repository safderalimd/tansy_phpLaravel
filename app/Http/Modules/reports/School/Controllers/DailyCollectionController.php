<?php

namespace App\Http\Modules\reports\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\reports\School\Models\DailyCollection;
use App\Http\PdfGenerator\Pdf;

class DailyCollectionController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . DailyCollection::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $export = new DailyCollection;
        return view('reports.school.DailyCollection.list', compact('export'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        $export = new DailyCollection($request->input());
        $export->loadPdfData();
        $view = view('reports.school.DailyCollection.pdf', compact('export'));
        return Pdf::render($view);
    }
}
