<?php

namespace App\Http\FPDF\ReceiptPrint;
use BasePDF;

require app_path('Http/FPDF/fpdf181/base-fpdf.php');

class ReceiptV2PDF extends BasePDF
{
    public function generate($export)
    {
        $this->setContents(new ReceiptV2Contents($export));
        $this->SetTitle($this->contents->reportName);
        // $this->showPagination();
        $this->AddPage();
        $this->drawGrid();
        $this->drawSchoolHeaderLargeFont();

        $this->drawReceiptContents();

        $this->drawCenterLogoWatermark();
        $this->show();
    }

    public function drawGrid()
    {
        $this->SetDrawColor(221, 221, 221);
        $this->SetFillColor(245, 245, 245);
        $this->Rect(10, 10, $this->GetPageWidth()-20, 36, 'F');
        $this->Rect(10, 10, $this->GetPageWidth()-20, $this->GetPageHeight()-50, 'D');
        $this->Line(10, 46, $this->GetPageWidth()-10, 46);
    }

    public function drawReceiptContents()
    {
        $this->setXY(12, 48);
        $this->font(30); $this->fontType('B');
        $this->Cell(62, 10, $this->contents->reportName, 0, 0, 'L');

        $this->font(12); $this->fontType('');
        $this->Cell(62, 10, 'No: '.$this->contents->receiptNumber, 0, 0, 'C');
        $this->Cell(62, 10, 'Date: '.$this->contents->receiptDate, 0, 1, 'R');

        $this->Ln(1); $this->setX(12);
        $this->fontType('B');
        $this->CellWidthAuto(10, 'Received From: ');
        $this->fontType('');
        $this->MultiCell(0, 10, $this->contents->receivedFrom, 0, 'L');

        $this->Ln(1); $this->setX(12);
        $this->fontType('B');
        $this->CellWidthAuto(10, 'Amount: ');
        $this->fontType('');
        $this->MultiCell(0, 10, $this->contents->receiptAmount, 0, 'L');

        $this->Ln(1); $this->setX(12);
        $this->fontType('B');
        $this->CellWidthAuto(10, 'For Payment Of: ');
        $this->MultiCell(0, 10, '', 0, 'L');

        $this->Ln(1); $this->setX(12);
        $this->fontType('B');
        $this->CellWidthAuto(10, 'Received By: ');
        $this->fontType('');
        $this->MultiCell(0, 10, $this->contents->receivedBy, 0, 'L');
    }
}

