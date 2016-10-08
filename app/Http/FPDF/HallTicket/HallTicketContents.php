<?php

namespace App\Http\FPDF\HallTicket;

// Contents for each student row
class HallTicketContents
{
    public $headerSecondLine = '';
    public $headerThirdLine = '';
    public $reportName = 'HALL TICKET';
    public $website;

    public $schoolName;
    public $schoolCity;
    public $schoolWorkPhone;
    public $fiscalYear;

    public $examName;
    public $className;
    public $studentName;
    public $rollNumber;

    public $studentId;

    public $tickets = [];

    public $datesRow = [];

    public $weekdaysRow = [];

    public $hoursRows = [];

    public $subjectsRow = [];

    public $hallTicketNr;

    protected $export;

    public function __construct($export)
    {
        $this->export = $export;
        $this->tickets = $export->tickets;

        $this->schoolName = $export->organizationName();
        $this->headerSecondLine = $export->organizationLine2();
        $this->headerThirdLine = $export->organizationLine3();
        $this->website = $export->organizationWebsite();

        // $this->schoolName = $export->schoolName;
        $this->schoolCity = $export->schoolCity;
        $this->schoolWorkPhone = phone_number_spaces($export->schoolWorkPhone);
        $this->fiscalYear = $export->fiscalYear;
    }

    public function setTicket($ticket)
    {
        $this->examName = isset($ticket[0]['exam']) ? $ticket[0]['exam'] : '';
        $this->className = isset($ticket[0]['class_name']) ? $ticket[0]['class_name'] : '';
        $this->studentName = isset($ticket[0]['student_full_name']) ? $ticket[0]['student_full_name'] : '';
        $this->rollNumber = isset($ticket[0]['student_roll_number']) ? $ticket[0]['student_roll_number'] : '';
        $this->studentId = isset($ticket[0]['student_entity_id']) ? $ticket[0]['student_entity_id'] : '-';

        $this->hallTicketNr = isset($ticket[0]['hall_ticket_number']) ? $ticket[0]['hall_ticket_number'] : '-';

        $this->datesRow = [];
        $this->subjectsRow = [];
        $this->weekdaysRow = [];
        $this->hoursRows = [];

        foreach($ticket as $subjects) {
            $this->datesRow[] = $this->date($subjects['exam_date']);
            $this->weekdaysRow[] = $this->weekday($subjects['exam_date']);
            $this->subjectsRow[] = $subjects['subject_short_code'];
            $hour = isset($subjects['exam_start_time']) ? $subjects['exam_start_time'] : '';
            if ($hour !== '') {
                $hour = date('g:iA', strtotime($hour));
            }
            $this->hoursRows[] = $hour;
        }
    }

    public function showImage()
    {
        return $this->export->showImage();
    }

    public function date($date)
    {
        $date = strtotime($date);
        if (empty($date)) {
            return '-';
        }
        return date("M jS", $date);
    }

    public function weekday($date)
    {
        $date = strtotime($date);
        if (empty($date)) {
            return '-';
        }
        return date("l", $date);
    }
}
