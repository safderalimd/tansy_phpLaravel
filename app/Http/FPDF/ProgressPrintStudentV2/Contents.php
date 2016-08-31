<?php

namespace App\Http\FPDF\ProgressPrintStudentV2;

// Contents for each student row
class Contents
{
    protected $export;

    protected $progress;

    public $students;

    protected $student;

    // general data for all pages below ..
    public $title = 'Progress Student V2';
    public $schoolName = '';
    public $phoneNr = '';
    public $examName = '';

    // data for each student below ..
    public $studentName = '';
    public $className = '';
    public $rollNr = '';
    public $admissionNr = '';
    public $months = [];

    public $grandTotal = '';
    public $percentage = '';
    public $grade = '';
    public $gpa = '';

    public function __construct($export, $progress)
    {
        $this->export = $export;
        $this->progress = $progress;

        $this->students = $progress->students;
        $this->schoolName = $progress->organizationName;
        $this->phoneNr = phone_number($progress->mobilePhone);
        $this->examName = $progress->examName;
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
        $studentId = isset($firstItem['student_entity_id']) ? $firstItem['student_entity_id'] : null;
        $classStudentId = isset($firstItem['class_student_id']) ? $firstItem['class_student_id'] : null;

        $this->studentName = isset($firstItem['student_full_name']) ? $firstItem['student_full_name'] : null;
        $this->rollNr = isset($firstItem['student_roll_number']) ? $firstItem['student_roll_number'] : null;

        $this->className = isset($firstItem['class_name']) ? $firstItem['class_name'] : null;
        $this->admissionNr = isset($firstItem['admission_number']) ? $firstItem['admission_number'] : null;

        $subjectMaxTotal = isset($firstItem['subject_max_total']) ? $firstItem['subject_max_total'] : null;

        $this->months = $this->progress->attendance->where('class_student_id', $classStudentId);

        $this->grandTotal = isset($studentTotals['student_total_marks']) ? $studentTotals['student_total_marks'] : '';
        $this->percentage = isset($studentTotals['score_percent']) ? $studentTotals['score_percent'] : '';
        $this->grade = isset($studentTotals['grade']) ? $studentTotals['grade'] : '';
        $this->gpa = isset($studentTotals['gpa']) ? $studentTotals['gpa'] : '';
    }

    public function examTypes()
    {
        return $this->progress->examTypes;
    }
}
