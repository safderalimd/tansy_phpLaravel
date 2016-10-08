<?php

namespace App\Http\FPDF\FeeDueReport;

class FeeDueReportContents
{
    public $export;

    // general data for all pages below ..
    public $schoolName = '';
    public $phoneNr = '';
    public $reportName = '';

    public $filterCriteria = '';

    public function __construct($export)
    {
        $this->export = $export;

        $this->schoolName = $export->organizationName();
        $this->phoneNr =  phone_number_spaces($export->organizationLine2());
        $this->reportName = $export->reportName;
        $this->filterCriteria = $export->filterCriteria;
    }
}
