<?php

namespace App\Http\FPDF\AccountStatement;
use BasePDF;

require app_path('Http/FPDF/fpdf181/base-fpdf.php');

class AccountStatementPDF extends BasePDF
{
    protected $_cellWidth;
    protected $_leftMargin = 35;
    protected $drawLogoWatermark = true;

    public function generate($export)
    {
        $this->setContents(new AccountStatementContents($export));
        $this->SetTitle($this->contents->reportName);
        $this->showPagination();

        $this->AddPage();
        $this->drawHeaderV1();
        $this->drawAccountDetails();
        $this->drawPrintDateTime();
        $this->drawAccountStatementTable();
        $this->drawCenterWatermark();
        $this->show();
    }

    public function drawAccountDetails()
    {
        $this->Ln(3);
        $this->SetFont('Helvetica', '', 12);
        $this->CellWidthAuto(6, 'Student Name: ' . $this->contents->studentName);
        $this->Cell(0, 6, 'Class: ' . $this->contents->className, 0, 1, 'R');

        $this->CellWidthAuto(6, 'Parent Name: ' . $this->contents->parentName);
        $this->Cell(0, 6, 'Roll Number: ' . $this->contents->rollNumber, 0, 1, 'R');
    }

    public function drawAccountStatementTable()
    {
        $this->Ln(3);
        $this->font(12); $this->fontType('B');

        $this->setRowMultiCellHeight(10);
        $headerRow = ['Receipt Number', 'Receipt Date', 'Receipt Amount', 'New Balance', 'Financial Year Balance'];
        $this->Row($headerRow);

        $this->setCurrencyColumns([false, false, true, true, true]);

        $this->fontType('');
        $fill = true;
        foreach ($this->contents->export->pdfData as $item) {
            $row = [];
            $row[] = isset($item['receipt_number']) ? $item['receipt_number'] : '-';
            $row[] = isset($item['receipt_date']) ? style_date($item['receipt_date']) : '-';
            $row[] = isset($item['receipt_amount']) ? amount($item['receipt_amount']) : '-';
            $row[] = isset($item['new_balance']) ? amount($item['new_balance']) : '-';
            $row[] = isset($item['financial_year_balance']) ? amount($item['financial_year_balance']) : '-';

            $this->setRowMultiCellFill($fill);
            $this->Row($row);
            $fill = !$fill;
        }
        $this->resetCurrencyColumns();
    }
}

