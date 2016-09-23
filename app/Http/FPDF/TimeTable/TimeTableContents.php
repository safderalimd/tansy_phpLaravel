<?php

namespace App\Http\FPDF\TimeTable;

class TimeTableContents
{
    public $export;

    public $dropdownFilter;

    public $startDateFilter;

    public $schoolName;

    public $phoneNr;

    public $reportName = 'Time Table';

    public $weekDays;

    public $periods;

    public $rows;

    public function __construct($export)
    {
        $this->export = $export;

        $this->schoolName = $export->organizationName();
        $this->phoneNr = phone_number_spaces($export->organizationPhone());

        $this->dropdownFilter = $export->dropdownFilter;
        $this->startDateFilter = style_date($export->startDateFilter);

        $this->weekDays = $export->weekDays();
        $this->periods = $export->periods();
        $this->rows = $export->rows;
    }
}
