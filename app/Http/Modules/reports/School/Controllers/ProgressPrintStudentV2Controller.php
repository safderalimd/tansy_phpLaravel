<?php

namespace App\Http\Modules\reports\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\reports\School\Models\ProgressPrintStudentV2;
use App\Http\PdfGenerator\Pdf;
use App\Http\DetectDevice\Device;

class ProgressPrintStudentV2Controller extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('screen:' . ProgressPrintStudentV2::screenId());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        // todo: uncomment middleware

        $export = new ProgressPrintStudentV2;
        $export->setAttribute('exam_entity_id', $request->input('ei'));
        $export->setAttribute('class_entity_id', $request->input('ci'));
        $export->setAttribute('class_student_id', 0);
        $progress = $export->getPdfData();

        $view = view('reports.school.ProgressPrintStudentV2.pdf', compact('export', 'progress'));

            return $view;
        if (Device::isAndroidMobile()) {
        }

        $html = $view->render();
        return \PDF::loadHTML($html)
                    ->setPaper('a4')
                    ->setOrientation('landscape')
                    ->setOption('margin-bottom', 0)
                    ->inline('report.pdf');
    }
}
