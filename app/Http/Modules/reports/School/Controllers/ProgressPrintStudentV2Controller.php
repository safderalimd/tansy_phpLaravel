<?php

namespace App\Http\Modules\reports\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\reports\School\Models\ProgressPrintStudentV2;
use App\Http\FPDF\ProgressPrintStudentV2\V2PDF;
use App\Http\FPDF\ProgressPrintStudentV2\V3PDF;
use Device;

class ProgressPrintStudentV2Controller extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . ProgressPrintStudentV2::screenId());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        $export = new ProgressPrintStudentV2;
        $export->setAttribute('exam_entity_id', $request->input('ei'));
        $export->setAttribute('filter_entity_id', $request->input('ci'));
        $export->setAttribute('class_student_id', 0);
        $export->setAttribute('return_type', 'Student Report');
        $progress = $export->getPdfData();
        $reportVersion3 = $request->input('v') == 3 ? true : false;

        // show html for android
        if (Device::isAndroidMobile()) {
            if ($reportVersion3) {
                return view('reports.school.ProgressPrintStudentV2.pdf-v3', compact('export', 'progress'));
            } else {
                return view('reports.school.ProgressPrintStudentV2.pdf', compact('export', 'progress'));
            }
        }

        // show pdf
        if ($reportVersion3) {
            $pdf = V3PDF::landscape();
        } else {
            $pdf = V2PDF::landscape();
        }

        $pdf->generate($export, $progress);
    }
}
