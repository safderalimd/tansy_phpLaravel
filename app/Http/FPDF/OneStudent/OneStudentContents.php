<?php

namespace App\Http\FPDF\OneStudent;

class OneStudentContents
{
    protected $export;

    // general data for all pages below ..
    public $reportName = '';
    public $schoolName = '';
    public $headerSecondLine = '';
    public $headerThirdLine = '';
    public $website;

    // data for the student below ..
    public $firstName = '';
    public $lastName = '';
    public $dateOfBirth = '';
    public $gender = '';
    public $mobilePhone = '';
    public $homePhone = '';
    public $email = '';
    public $address1 = '';
    public $address2 = '';
    public $cityName = '';
    public $admissionNumber = '';
    public $admissionDate = '';
    public $admittedToClassGroup = '';
    public $className = '';
    public $studentRollNumber = '';
    public $identification1 = '';
    public $identification2 = '';
    public $casteName = '';
    public $religionName = '';
    public $motherTounge = '';
    public $parentFullName = '';
    public $parentDesignationName = '';

    public function __construct($export)
    {
        $this->export = $export;

        $this->schoolName = $export->organizationName();
        $this->headerSecondLine = $export->organizationLine2();
        $this->headerThirdLine = $export->organizationLine3();
        $this->website = $export->organizationWebsite();
        $this->reportName = $export->reportName;

        // set the student data
        $s = $export->pdfData;
        $this->firstName             = isset($s['first_name']) ? $s['first_name'] : '-';
        $this->lastName              = isset($s['last_name']) ? $s['last_name'] : '-';
        $this->dateOfBirth           = isset($s['date_of_birth']) ? style_date($s['date_of_birth']) : '-';
        $this->gender                = isset($s['gender']) ? $s['gender'] : '-';
        $this->mobilePhone           = isset($s['mobile_phone']) ? phone_number($s['mobile_phone']) : '-';
        $this->homePhone             = isset($s['home_phone']) ? phone_number($s['home_phone']) : '-';
        $this->email                 = isset($s['email']) ? $s['email'] : '-';
        $this->address1              = isset($s['address1']) ? $s['address1'] : '';
        $this->address2              = isset($s['address2']) ? $s['address2'] : '';
        $this->cityName              = isset($s['city_name']) ? $s['city_name'] : '-';
        $this->admissionNumber       = isset($s['admission_number']) ? $s['admission_number'] : '-';
        $this->admissionDate         = isset($s['admission_date']) ? style_date($s['admission_date']) : '-';
        $this->admittedToClassGroup  = isset($s['admitted_to_class_group']) ? $s['admitted_to_class_group'] : '-';
        $this->className             = isset($s['class_name']) ? $s['class_name'] : '-';
        $this->studentRollNumber     = isset($s['student_roll_number']) ? $s['student_roll_number'] : '-';
        $this->identification1       = isset($s['identification1']) ? $s['identification1'] : '-';
        $this->identification2       = isset($s['identification2']) ? $s['identification2'] : '-';
        $this->casteName             = isset($s['caste_name']) ? $s['caste_name'] : '-';
        $this->religionName          = isset($s['religion_name']) ? $s['religion_name'] : '-';
        $this->motherTounge          = isset($s['mother_tounge']) ? $s['mother_tounge'] : '-';
        $this->parentFullName        = isset($s['parent_full_name']) ? $s['parent_full_name'] : '-';
        $this->parentDesignationName = isset($s['parent_designation_name']) ? $s['parent_designation_name'] : '-';
    }
}
