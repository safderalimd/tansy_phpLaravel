<?php

namespace App\Http\FPDF\ProgressPrintClass;

class ProgressPrintClassContents
{
    public $export;

    public $progress;

    // general data for all pages below ..
    public $schoolName = '';
    public $phoneNr = '';
    public $reportName = '';

    public $className = '';
    public $maxTotalMarks = '';

    public $allSubjects;

    public $studentName = '';
    public $rollNr = '';
    public $grandTotal = '';
    public $grade = '';
    public $percentage = '';
    public $gpa = '';
    public $passFail = '';

    public function __construct($export, $progress)
    {
        $this->export = $export;
        $this->progress = $progress;

        $this->schoolName = $export->organizationName();
        $this->phoneNr =  phone_number_spaces($export->organizationPhone());
        $this->reportName = $progress->examName . ' - Progress Report';

        $this->allSubjects = $progress->getAllSubjects();

        $firstStudent = $progress->students->first();
        $firstStudentTotals = $progress->getTotal($firstStudent);
        $firstItem = $firstStudent->first();

        $this->className = isset($firstItem['class_name']) ? $firstItem['class_name'] : null;
        $this->maxTotalMarks = isset($firstStudentTotals['max_total_marks']) ? $firstStudentTotals['max_total_marks'] : null;
    }

    public function setStudent($student)
    {
        $this->student = $student;
        $studentTotals = $this->progress->getTotal($student);

        $firstItem = $student->first();

        $this->studentName = isset($firstItem['student_full_name']) ? $firstItem['student_full_name'] : null;
        $this->rollNr = isset($firstItem['student_roll_number']) ? $firstItem['student_roll_number'] : null;

        $this->grandTotal = isset($studentTotals['student_total_marks']) ? $studentTotals['student_total_marks'] : '';
        $this->grade = isset($studentTotals['grade']) ? $studentTotals['grade'] : '';
        $this->percentage = isset($studentTotals['score_percent']) ? $studentTotals['score_percent'] : '';
        $this->gpa = isset($studentTotals['gpa']) ? $studentTotals['gpa'] : '';
        $this->passFail = isset($studentTotals['pass_fail']) ? $studentTotals['pass_fail'] : '';
    }
}
