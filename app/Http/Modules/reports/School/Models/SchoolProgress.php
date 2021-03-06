<?php

namespace App\Http\Modules\reports\School\Models;

use App\Http\Models\Model;

class SchoolProgress
{
    public $organizationName;

    public $mobilePhone;

    public $examName;

    public $examTypes = [];

    public $coCuricullarTypes = [];

    public $students;

    public $totals;

    public $attendance;

    public $headerSecondLine;

    public $headerThirdLine;

    public $colors;

    public $coCuricullar;

    public function __construct($data)
    {
        $this->setExamTypes(first_resultset($data));

        $this->students = collect(first_resultset($data));
        $this->students = $this->students->groupBy('class_student_id');

        $this->totals = collect(second_resultset($data));

        $this->setSchoolInfo(third_resultset($data));
        $this->attendance = collect(fourth_resultset($data));

        $colors = isset($data[4]) ? $data[4] : [];
        $this->colors = collect($colors);

        $coCuricullar = isset($data[5]) ? $data[5] : [];
        $this->setCocuricullarTypes($coCuricullar);
        $this->coCuricullar = collect($coCuricullar); 
    }

    public function getTotal($student)
    {
        $student = $student->first();
        $id = isset($student['class_student_id']) ? $student['class_student_id'] : null;

        foreach ($this->totals as $total) {
            if (isset($total['class_student_id']) && $id == $total['class_student_id']) {
                return $total;
            }
        }

        return [];
    }

    public function setCocuricullarTypes($types)
    {
        $types = isset($types[0]) ? $types[0] : [];        
        $skip = ['class_student_id', 'exam', 'sub_gpa'];
        foreach ($types as $type => $value) {
            if (!is_numeric($type) && !in_array($type, $skip)) {
                $this->coCuricullarTypes[] = $type;
            }
        }
    }

    public function setExamTypes($types)
    {
        $types = isset($types[0]) ? $types[0] : [];
        $skip = ['class_student_id', 'student_roll_number', 'student_full_name', 'subject_name', 'student_subject_max_total', 'subject_gpa', 'subject_short_code', 'subject_order', 'main_exam_name', 'student_entity_id', 'admission_number', 'class_name', 'subject_max_total', 'student_subject_percent', 'student_previous_subject_percent', 'subject_entity_id'];

        foreach ($types as $type => $value) {
            if (!is_numeric($type) && !in_array($type, $skip)) {
                $this->examTypes[] = $type;
            }
        }
    }

    public function setSchoolInfo($school)
    {
        $school = isset($school[0]) ? $school[0] : [];

        $this->organizationName = isset($school['organization_name']) ? $school['organization_name'] : '-';
        $this->mobilePhone = isset($school['mobile_phone']) ? $school['mobile_phone'] : '-';
        $this->examName = isset($school['exam_name']) ? $school['exam_name'] : '-';

        $this->headerSecondLine = isset($school['report_header_second_line']) ? $school['report_header_second_line'] : '';
        $this->headerThirdLine = isset($school['report_header_third_line']) ? $school['report_header_third_line'] : '';
    }

    public function getAllSubjects()
    {
        // get a list of the subjects alphabetically
        $allSubjects = [];
        foreach($this->students as $student) {
            foreach ($student as $subject) {
                if (isset($subject['subject_name'])) {
                    $allSubjects[] = $subject['subject_name'];
                }
            }
        }
        $allSubjects = collect($allSubjects);
        return $allSubjects->unique();
    }
}
