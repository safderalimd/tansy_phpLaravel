<?php

namespace App\Http\FPDF\DICE;

class DICEContents
{
    protected $export;

    // general data for all pages below ..
    public $reportName = '';
    public $schoolName = '';
    public $headerSecondLine = '';
    public $headerThirdLine = '';
    public $website;

    public $dice;

    public function __construct($export)
    {
        $this->export = $export;

        $this->dice = $export->dice();

        $this->schoolName = $export->organizationName();
        $this->headerSecondLine = $export->organizationLine2();
        $this->headerThirdLine = $export->organizationLine3();
        $this->website = $export->organizationWebsite();
        $this->reportName = $export->reportName;  
    }
}
