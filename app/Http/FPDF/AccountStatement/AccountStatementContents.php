<?php

namespace App\Http\FPDF\AccountStatement;

class AccountStatementContents
{
    public $export;

    // general data for all pages below ..
    public $schoolName = '';
    public $headerSecondLine = '';
    public $headerThirdLine = '';
    public $reportName = '';
    public $website;

    public $studentName = '';
    public $className = '';
    public $parentName = '';
    public $rollNumber = '';

    public function __construct($export)
    {
        $this->export = $export;

        $this->schoolName = $export->organizationName();
        $this->headerSecondLine = $export->organizationLine2();
        $this->headerThirdLine = $export->organizationLine3();
        $this->website = $export->organizationWebsite();
        $this->reportName = $export->reportName;


        $this->studentName = isset($export->studentData['student_full_name']) ? $export->studentData['student_full_name'] : '-';
        $this->className = isset($export->studentData['class_name']) ? $export->studentData['class_name'] : '-';
        $this->parentName = isset($export->studentData['parent_full_name']) ? $export->studentData['parent_full_name'] : '-';
        $this->rollNumber = isset($export->studentData['student_roll_number']) ? $export->studentData['student_roll_number'] : '-';
    }
}
