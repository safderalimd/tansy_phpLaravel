<?php

namespace App\Http\Modules\reports\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\reports\School\Models\StudentDetail;
use App\Http\PdfGenerator\Pdf;

class StudentDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $export = new StudentDetail;
        return view('reports.school.StudentDetail.list', compact('export'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        $export = new StudentDetail($request->input());
        $export->loadPdfData();
        $view = view('reports.school.StudentDetail.pdf', compact('export'));
        return Pdf::render($view);
    }
}
