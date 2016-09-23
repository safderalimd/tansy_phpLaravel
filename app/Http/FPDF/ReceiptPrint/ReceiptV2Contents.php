<?php

namespace App\Http\FPDF\ReceiptPrint;

use NumberFormatter;

class ReceiptV2Contents
{
    public $export;

    // general data for all pages below ..
    public $schoolName = '';
    public $phoneNr = '';
    public $reportName = '';

    public $details = [];

    public $headerSecondLine = '';
    public $headerThirdLine = '';

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

        $this->schoolName = isset($org['organization_name']) ? $org['organization_name'] : '';
        $this->phoneNr = isset($org['mobile_phone']) ? phone_number_spaces($org['mobile_phone']) : '-';
        $this->phoneNr = 'Phone: ' . $this->phoneNr;
        $this->reportName = 'RECEIPT';

        $this->headerSecondLine = isset($org['report_header_second_line']) ? $org['report_header_second_line'] : '-';
        $this->headerThirdLine = isset($org['report_header_third_line']) ? $org['report_header_third_line'] : '-';

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
        $this->academicDue = isset($amounts['due_amount']) ? amount($amounts['due_amount']) : '-';

        // $this->productName = isset($details['product_name']) ? $details['product_name'] : '-';
        // $this->productCreditAmount = isset($details['product_credit_amount']) ? amount($details['product_credit_amount']) : '-';
    }
}
