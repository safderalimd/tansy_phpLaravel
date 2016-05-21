<?php

namespace App\Http\Modules\reports\School\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\reports\School\Models\StudentExport;
use App\Http\Modules\reports\School\Requests\StudentExportFormRequest;

class StudentExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $export = new StudentExport;
        return view('reports.school.StudentExport.list', compact('export'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  StudentExportFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function report(StudentExportFormRequest $request)
    {
        // TODO: generate report only for filtered rows
        // dd($request->input());
        $export = new StudentExport($request->input());

        dd($export->pdfData());

        return view('reports.school.StudentExport.form', compact('export'));
    }

}
