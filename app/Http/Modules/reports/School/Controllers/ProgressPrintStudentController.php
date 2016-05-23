<?php

namespace App\Http\Modules\reports\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\reports\School\Models\ProgressPrintStudent;
use Dompdf\Dompdf;
use Dompdf\Options;

class ProgressPrintStudentController extends Controller
{
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
        $export->setAttribute('class_entity_id', $request->input('ci'));
        $export->setAttribute('class_student_id', 0);

        $export->loadPdfData();

        $view = view('reports.school.ProgressPrintStudent.pdf', compact('export'));
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
