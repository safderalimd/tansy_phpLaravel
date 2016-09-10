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
    public $schoolName = '';
    public $reportName = '';
    public $phoneNr = '';
    public $examName = '';

    // data for each student below ..
    public $studentName = '';
    public $className = '';
    public $rollNr = '';

    public $grandTotal = '';
    public $percentage = '';
    public $grade = '';
    public $gpa = '';
    public $maxTotalMarks = '';

    public function __construct($export, $progress)
    {
        $this->export = $export;
        $this->progress = $progress;

        $this->students = $progress->students;
        $this->schoolName = $progress->organizationName;
        $this->phoneNr = phone_number($progress->mobilePhone);
        $this->examName = $progress->examName;

        $this->reportName = 'Progress Report - ' . $this->examName;
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
