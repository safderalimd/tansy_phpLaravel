<?php

namespace App\Http\Modules\reports\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\reports\School\Models\ProgressPrintClass;
use App\Http\CSVGenerator\CSV;
use App\Http\FPDF\ProgressPrintClass\ProgressPrintClassPDF;
use Device;

class ProgressPrintClassController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . ProgressPrintClass::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $progress = new ProgressPrintClass;
        return view('reports.school.ProgressPrintClass.list', compact('progress'));
    }

    public function report(Request $request)
    {
        $export = new ProgressPrintClass;
        $export->setAttribute('exam_entity_id', $request->input('ei'));
        $export->setAttribute('filter_entity_id', $request->input('ci'));
        $export->setAttribute('class_student_id', 0);
        $export->setAttribute('return_type', 'Class Report');
        $progress = $export->getPdfData();

        if (Device::isAndroidMobile()) {
            return view('reports.school.ProgressPrintClass.pdf', compact('export', 'progress'));
        } else {
            ProgressPrintClassPDF::landscape()->generate($export, $progress);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function csv(Request $request)
    {
        $export = new ProgressPrintClass;
        $export->setAttribute('exam_entity_id', $request->input('ei'));
        $export->setAttribute('filter_entity_id', $request->input('ci'));
        $export->setAttribute('class_student_id', 0);
        $export->setAttribute('return_type', 'Class Report');
        $progress = $export->getPdfData();

        $studentRows = [];

        $allSubjects = $progress->getAllSubjects();
        $allSubjects = $allSubjects->sort();

        $firstRow = ['Class Name', 'Roll Number', 'Name'];
        foreach ($allSubjects as $oneSubject) {
            foreach($progress->examTypes as $type) {
                $firstRow[] = $type;
            }
            $firstRow[] = 'Subject Total';
            $firstRow[] = 'Subject GPA';
        }
        $firstRow[] = '';
        $firstRow[] = '';
        $firstRow[] = '';
        $firstRow[] = '';
        $firstRow[] = '';

        // build rows
        foreach($progress->students as $student) {
            $row = [];

            $studentTotals = $progress->getTotal($student);

            $firstItem = $student->first();

            $className = isset($firstItem['class_name']) ? $firstItem['class_name'] : null;
            $studentName = isset($firstItem['student_full_name']) ? $firstItem['student_full_name'] : null;
            $rollNr = isset($firstItem['student_roll_number']) ? $firstItem['student_roll_number'] : null;

            $row[] = $className;
            $row[] = $rollNr;
            $row[] = $studentName;


            foreach ($allSubjects as $oneSubject) {

                $subject = $student->where('subject_name', $oneSubject)->first();

                // subject
                foreach($progress->examTypes as $type) {
                    if (isset($subject[$type])) {
                        $row[] = $subject[$type];
                    } else {
                        $row[] = '';
                    }
                }

                // subject total
                if (isset($subject['student_subject_max_total'])) {
                    $row[] = $subject['student_subject_max_total'];
                } else {
                    $row[] = '';
                }

                // subject gpa
                if (isset($subject['subject_gpa'])) {
                    $row[] = $subject['subject_gpa'];
                } else {
                    $row[] = '';
                }
            }

            // max total
            if (isset($studentTotals['max_total_marks'])) {
                $row[] = $studentTotals['max_total_marks'];
            } else {
                $row[] = '';
            }

            // student total
            if (isset($studentTotals['student_total_marks'])) {
                $row[] = $studentTotals['student_total_marks'];
            } else {
                $row[] = '';
            }

            // percentage
            if (isset($studentTotals['score_percent'])) {
                $row[] = $studentTotals['score_percent'];
            } else {
                $row[] = '';
            }

            // grade
            if (isset($studentTotals['grade'])) {
                $row[] = $studentTotals['grade'];
            } else {
                $row[] = '';
            }

            // gpa
            if (isset($studentTotals['gpa'])) {
                $row[] = $studentTotals['gpa'];
            } else {
                $row[] = '';
            }

            $studentRows[] = $row;
        }

        // header
        $header = ['', '', ''];
        foreach ($allSubjects as $value) {
            $header[] = $value;
            for ($i=0; $i<count($progress->examTypes); $i++) {
                $header[] = '';
            }
            $header[] = '';
        }
        $header[] = 'Max. TOTAL';
        $header[] = 'Student TOTAL';
        $header[] = 'Percentage';
        $header[] = 'Grade';
        $header[] = 'GPA';

        array_unshift($studentRows, $firstRow);
        return CSV::make($header, $studentRows);
    }
}
