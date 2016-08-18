<?php

namespace App\Http\Modules\reports\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\reports\School\Models\ProgressPrintClass;
use App\Http\PdfGenerator\Pdf;
use App\Http\CSVGenerator\CSV;

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

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        $export = new ProgressPrintClass;
        $export->setAttribute('exam_entity_id', $request->input('ei'));
        $export->setAttribute('filter_entity_id', $request->input('ci'));
        $export->setAttribute('class_student_id', 0);
        $export->setAttribute('return_type', 'Class Report');
        $progress = $export->getPdfData();

        $studentRows = [];

        // get a list of the subjects alphabetically
        $allSubjects = [];
        foreach($progress->students as $student) {
            foreach ($student as $subject) {
                if (isset($subject['subject_name'])) {
                    $allSubjects[] = $subject['subject_name'];
                }
            }
        }
        $allSubjects = collect($allSubjects);
        $allSubjects = $allSubjects->unique();
        $allSubjects = $allSubjects->sort();

        $firstRow = ['Roll Number', 'Name'];
        foreach ($allSubjects as $oneSubject) {
            foreach($progress->examTypes as $type) {
                $firstRow[] = $type;
            }
            $firstRow[] = 'Subject Total';
        }
        $firstRow[] = '';
        $firstRow[] = '';
        $firstRow[] = '';

        // build rows
        foreach($progress->students as $student) {
            $row = [];

            $studentTotals = $progress->getTotal($student);

            $firstItem = $student->first();
            $studentName = isset($firstItem['student_full_name']) ? $firstItem['student_full_name'] : null;
            $rollNr = isset($firstItem['student_roll_number']) ? $firstItem['student_roll_number'] : null;

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
            }

            // max total
            if (isset($studentTotals['student_total_marks'])) {
                $row[] = $studentTotals['student_total_marks'];
            } else {
                $row[] = '';
            }

            // student total
            if (isset($studentTotals['student_total_marks'])) {
                $row[] = $studentTotals['student_total_marks'];
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
        $header = ['', ''];
        foreach ($allSubjects as $value) {
            $header[] = $value;
            for ($i=0; $i<count($progress->examTypes); $i++) {
                $header[] = '';
            }
        }
        $header[] = 'Max. TOTAL';
        $header[] = 'Student TOTAL';
        $header[] = 'GPA';

        array_unshift($studentRows, $firstRow);
        return CSV::make($header, $studentRows);
    }
}
