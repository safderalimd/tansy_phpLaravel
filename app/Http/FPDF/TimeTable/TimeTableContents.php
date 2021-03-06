<?php

namespace App\Http\FPDF\TimeTable;

class TimeTableContents
{
    public $export;

    public $dropdownFilter;

    public $startDateFilter;

    public $schoolName;

    public $website;

    public $headerSecondLine = '';

    public $headerThirdLine = '';

    public $reportName = 'Time Table';

    public $weekDays;

    public $periods;

    public $rows;

    public function __construct($export)
    {
        $this->export = $export;

        $this->schoolName = $export->organizationName();
        $this->headerSecondLine = $export->organizationLine2();
        $this->headerThirdLine = $export->organizationLine3();
        $this->website = $export->organizationWebsite();

        $this->dropdownFilter = $export->dropdownFilter;
        $this->startDateFilter = style_date($export->startDateFilter);

        $this->weekDays = $export->weekDays();
        $this->periods = $export->periods();
        $this->rows = $export->rows;
    }

    public function showType()
    {
        return $this->export->showType();
    }
}
