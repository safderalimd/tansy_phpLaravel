<?php

namespace App\Http\FPDF\FeeDueReport;

class FeeDueReportContents
{
    public $export;

    // general data for all pages below ..
    public $schoolName = '';
    public $headerSecondLine = '';
    public $headerThirdLine = '';
    public $reportName = '';
    public $website;

    public $filterCriteria = '';

    public function __construct($export)
    {
        $this->export = $export;

        $this->schoolName = $export->organizationName();
        $this->headerSecondLine = $export->organizationLine2();
        $this->headerThirdLine = $export->organizationLine3();
        $this->website = $export->organizationWebsite();
        $this->reportName = $export->reportName;
        $this->filterCriteria = $export->filterCriteria;
    }
}
