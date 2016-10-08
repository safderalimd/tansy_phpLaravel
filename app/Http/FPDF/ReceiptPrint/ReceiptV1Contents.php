<?php

namespace App\Http\FPDF\ReceiptPrint;

class ReceiptV1Contents
{
    public $export;

    // general data for all pages below ..
    public $schoolName = '';
    public $phoneNr = '';
    public $reportName = '';

    public $studentName = '';
    public $mobileNo = '';
    public $receiptNo = '';
    public $receiptDate = '';

    public $totalPaid = '';
    public $newBalance = '';
    public $fiscalYearBalance = '';

    public function __construct($export)
    {
        $this->export = $export;

        $this->schoolName = $export->organizationName();
        $this->phoneNr =  phone_number_spaces($export->organizationLine2());
        $this->reportName = $export->reportName;

        $this->studentName = isset($export->header['paid_by_name']) ? $export->header['paid_by_name'] : '-';
        $this->mobileNo    = isset($export->header['mobile_phone']) ? phone_number($export->header['mobile_phone']) : '-';
        $this->receiptNo   = isset($export->header['receipt_number']) ? $export->header['receipt_number'] : '-';
        $this->receiptDate = isset($export->header['receipt_date']) ? style_date($export->header['receipt_date']) : '-';

        $this->totalPaid = isset($export->header['receipt_amount']) ? amount($export->header['receipt_amount']) : '-';
        $this->newBalance = isset($export->header['new_balance']) ? amount($export->header['new_balance']) : '-';
        $this->fiscalYearBalance = isset($export->header['financial_year_balance']) ? amount($export->header['financial_year_balance']) : '-';
    }
}
