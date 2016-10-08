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
        $this->AddPage();
        $this->drawGrid();
        $this->drawHeaderV1();
        $this->drawReceiptContents();
        $this->drawReceiptPrintDate();

        $endY = $this->getY();
        $this->Rect(10, 10, $this->GetPageWidth()-20, $endY-10+1, 'D');

        $this->drawCenterLogoWatermark(0, -65);
        $this->show();
    }

    public function drawGrid()
    {
        $this->SetDrawColor(221, 221, 221);
        $this->SetFillColor(245, 245, 245);
        $this->Rect(10, 10, $this->GetPageWidth()-20, 36, 'F');
        // $this->Rect(10, 10, $this->GetPageWidth()-20, $this->GetPageHeight()-50, 'D');
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
        $this->Cell(40, 10, 'Received From: ', 0, 0, 'R');
        $this->fontType('');
        $this->MultiCell(0, 10, $this->contents->receivedFrom, 0, 'L');

        $this->Ln(1); $this->setX(12);
        $this->fontType('B');
        $this->font(10);
        $this->Cell(40, 10, 'Amount: ', 0, 0, 'R');
        $this->fontType('');
        $this->MultiCell(0, 10, $this->contents->receiptAmount, 0, 'L');

        $this->font(12);
        $this->Ln(1); $this->setX(12);
        $this->fontType('B');
        $this->Cell(40, 10, 'For Payment Of: ', 0, 0, 'R');
        $this->MultiCell(0, 10, '', 0, 'L');

        $rowY = $this->getY();
        $this->fontType('');
        foreach ($this->contents->details as $row) {
            $productName = isset($row['product_name']) ? $row['product_name'] : '-';
            $productAmount = isset($row['product_credit_amount']) ? amount($row['product_credit_amount']) : '-';
            $this->setXY(52, $rowY);
            $this->MultiCell(105, 10, $productName, 0, 'L');
            $y1 = $this->getY();
            $this->setXY(157, $rowY);
            $this->MultiCellAmount(38, 10, $productAmount.' ', 0, 'R');
            $y2 = $this->getY();
            $rowY = max($y1, $y2);
        }

        $currentY = $this->getY();

        $this->setXY(12, $currentY+15);
        $this->fontType('B');
        $this->Cell(40, 10, 'Received By: ', 0, 0, 'R');
        $this->fontType('');
        $this->MultiCell(40, 10, $this->contents->receivedBy, 0, 'L');

        $this->setXY(105, $currentY+5);
        $this->Cell(45, 10, 'This Payment', 1, 0, 'C');
        $this->CellAmount(45, 10, $this->contents->thisPayment.' ', 1, 1, 'R');
        $this->setX(105);
        $this->Cell(45, 10, 'Academic Due', 1, 0, 'C');
        $this->CellAmount(45, 10, $this->contents->academicDue.' ', 1, 1, 'R');
    }

    public function drawReceiptPrintDate()
    {
        $this->Ln(2);
        $this->setX(12);
        $this->fontType('');
        $this->font(8);
        $this->SetTextColor(51, 51, 51);
        $this->Cell(0, 6, 'Receipt Print Time: '.current_datetime(), 0, 1, 'L');
    }
}

