<?php

namespace App\Http\FPDF\ProgressPrintStudent;

class V1Contents
{
    protected $export;

    protected $progress;

    public $students;

    protected $student;

    // general data for all pages below ..
    public $title = 'Progress Report';
    public $schoolName = 'Canadian International School';
    public $reportName = 'Progress Report - Formative Assessment-1';
    public $phoneNr = '880 193 3344';
    public $examName = 'Formative Assessment-1';

    // data for each student below ..
    public $studentName = 'John Doe';
    public $className = 'X-A';
    public $rollNr = '3';

    public $grandTotal = '110';
    public $percentage = '92';
    public $grade = 'A2';
    public $gpa = '9.00';
    public $maxTotalMarks = '135';

    public function __construct($export, $progress)
    {
        return;
        $this->export = $export;
        $this->progress = $progress;

        $this->students = $progress->students;
        $this->schoolName = $progress->organizationName;
        $this->phoneNr = phone_number($progress->mobilePhone);
        $this->examName = $progress->examName;

        $this->reportName = 'Progress Report - ' . $this->contents->examName;
    }

    public function getStudent()
    {
        return $this->student;
    }

    public function setStudent($student)
    {
        $this->student = $student;
        $studentTotals = $this->progress->getTotal($student);

        $firstItem = $student->first();

        $this->studentName = isset($firstItem['student_full_name']) ? $firstItem['student_full_name'] : null;
        $this->rollNr = isset($firstItem['student_roll_number']) ? $firstItem['student_roll_number'] : null;
        $this->className = isset($firstItem['class_name']) ? $firstItem['class_name'] : null;

        $this->grandTotal = isset($studentTotals['student_total_marks']) ? $studentTotals['student_total_marks'] : '';
        $this->percentage = isset($studentTotals['score_percent']) ? $studentTotals['score_percent'] : '';
        $this->grade = isset($studentTotals['grade']) ? $studentTotals['grade'] : '';
        $this->gpa = isset($studentTotals['gpa']) ? $studentTotals['gpa'] : '';
        $this->maxTotalMarks = isset($studentTotals['max_total_marks']) ? $studentTotals['max_total_marks'] : '';
    }
}
