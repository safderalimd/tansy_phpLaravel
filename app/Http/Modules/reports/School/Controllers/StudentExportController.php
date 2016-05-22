<?php

namespace App\Http\Modules\reports\School\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\reports\School\Models\StudentExport;
use App\Http\Modules\reports\School\Requests\StudentExportFormRequest;
use Dompdf\Dompdf;
use Dompdf\Options;

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
        $export = new StudentExport($request->input());
        $export->loadPdfData();

        $view = view('reports.school.StudentExport.pdf', compact('export'));
        $html = $view->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'letter');
        $dompdf->render();

        $output = $dompdf->output();
        return response($output)
            ->header('Content-Type', 'application/pdf')
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }

}
