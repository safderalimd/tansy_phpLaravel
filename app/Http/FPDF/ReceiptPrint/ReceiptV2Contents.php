<?php

namespace App\Http\FPDF\ReceiptPrint;

use NumberFormatter;

class ReceiptV2Contents
{
    public $export;

    // general data for all pages below ..
    public $schoolName = '';
    public $reportName = '';

    public $details = [];

    public $headerSecondLine = '';
    public $headerThirdLine = '';
    public $website;

    public $receiptNumber = '';
    public $receiptDate = '';
    public $receivedFrom = '';
    public $receiptAmount = '';
    public $receivedBy = '';

    public $thisPayment = '';
    public $academicDue = '';

    public function __construct($export)
    {
        $this->export = $export;
        $data = $this->export->getPdfDataV2();

        $details = first_resultset($data);
        $this->details = $details;
        $details = isset($details[0]) ? $details[0] : [];

        $amounts = second_resultset($data);
        $amounts = isset($amounts[0]) ? $amounts[0] : [];
        $org = third_resultset($data);
        $org = isset($org[0]) ? $org[0] : [];

        $this->schoolName = $export->organizationName();
        $this->headerSecondLine = $export->organizationLine2();
        $this->headerThirdLine = $export->organizationLine3();
        $this->website = $export->organizationWebsite();
        $this->reportName = 'RECEIPT';

        $this->receiptNumber = isset($details['receipt_number']) ? $details['receipt_number'] : '-';
        $this->receiptDate = isset($details['receipt_date']) ? style_date($details['receipt_date']) : '-';
        $this->receivedFrom = isset($details['received_from']) ? $details['received_from'] : '-';

        $this->receiptAmount = isset($details['receipt_amount']) ? $details['receipt_amount'] : '-';
        if ($this->receiptAmount != '-') {
            $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
            $this->receiptAmount = $f->format($this->receiptAmount);
            $this->receiptAmount = ucfirst($this->receiptAmount) . ' rupees only';
        }

        $this->receivedBy = isset($details['received_by']) ? $details['received_by'] : '-';

        $this->thisPayment = isset($details['receipt_amount']) ? amount($details['receipt_amount']) : '-';
        $this->academicDue = isset($amounts['due_amount']) ? amount($amounts['due_amount']) : '0';
    }
}
