<?php

namespace App\Http\FPDF\ProgressPrintStudent;

// Contents for each student row
class ProgressPrintStudentContents
{
    public $schoolName;
    public $schoolCity;
    public $schoolWorkPhone;

    public $examName;
    public $className;
    public $studentName;
    public $rollNumber;

    public $studentId;

    public $tickets = [];

    public $datesRow = [];

    public $subjectsRow = [];

    protected $export;

    public function __construct($export)
    {
        $this->export = $export;
        $this->tickets = $export->tickets;

        $this->schoolName = $export->schoolName;
        $this->schoolCity = $export->schoolCity;
        $this->schoolWorkPhone = phone_number_spaces($export->schoolWorkPhone);
    }

    public function setTicket($ticket)
    {
        $this->examName = isset($ticket[0]['exam']) ? $ticket[0]['exam'] : '';
        $this->className = isset($ticket[0]['class_name']) ? $ticket[0]['class_name'] : '';
        $this->studentName = isset($ticket[0]['student_full_name']) ? $ticket[0]['student_full_name'] : '';
        $this->rollNumber = isset($ticket[0]['student_roll_number']) ? $ticket[0]['student_roll_number'] : '';
        $this->studentId = isset($ticket[0]['student_entity_id']) ? $ticket[0]['student_entity_id'] : '-';

        $this->datesRow = [];
        $this->subjectsRow = [];

        foreach($ticket as $subjects) {
            $this->datesRow[] = hall_ticket_date($subjects['exam_date']);
            $this->subjectsRow[] = $subjects['subject_name'];
        }
    }

    public function showImage()
    {
        return $this->export->showImage();
    }
}
