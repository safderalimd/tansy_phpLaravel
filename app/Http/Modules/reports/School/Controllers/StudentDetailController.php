<?php

namespace App\Http\Modules\reports\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\reports\School\Models\StudentDetail;
use App\Http\PdfGenerator\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;

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
        // return Pdf::render($view);

        $html = $view->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'letter');
        $dompdf->render();
        $dompdf->stream();

        // $output = $dompdf->output();
        // return response($output)
        //     ->header('Content-Type', 'application/pdf')
        //     ->header('Content-Disposition', 'inline; filename="report.pdf')
        //     ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
        //     ->header('Pragma', 'no-cache')
        //     ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }
}
