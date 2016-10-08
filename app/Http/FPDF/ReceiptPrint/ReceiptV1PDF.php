<?php

namespace App\Http\FPDF\ReceiptPrint;
use BasePDF;

require app_path('Http/FPDF/fpdf181/base-fpdf.php');

class ReceiptV1PDF extends BasePDF
{
    public function generate($export)
    {
        $this->setContents(new ReceiptV1Contents($export));
        $this->SetTitle($this->contents->reportName);
        $this->showPagination();

        $this->AddPage();
        $this->drawHeaderV1();
        $this->Ln(3);
        $this->drawPrintDateTime();
        $this->drawFirstReceiptTable();
        $this->drawSecondReceiptTable();
        $this->drawAfterGridInfo();
        $this->drawCenterWatermark();
        $this->show();
    }

    public function drawFirstReceiptTable()
    {
        $this->Ln(3);
        $originalX = $this->getX();
        $originalY = $this->getY();

        // 210
        // 100 30 40 30
        $w1 = 90;
        $w2 = 32;
        $w3 = 36;
        $w4 = 32;
        $h = 10;

        $this->fontType('B');
        $this->Cell($w1, $h, 'Student Name', 0, 0, 'C');
        $this->Cell($w2, $h, 'Mobile No.', 0, 0, 'C');
        $this->Cell($w3, $h, 'Receipt No.', 0, 0, 'C');
        $this->Cell($w4, $h, 'Receipt Date', 0, 1, 'C');

        $secondY = $this->getY();

        $this->fontType('');
        $this->MultiCell($w1, $h, $this->contents->studentName, 0, 'C');
        $maxY = $this->getY();

        $this->setXY(10 + $w1, $secondY);
        $this->MultiCell($w2, $h, $this->contents->mobileNo, 0, 'C');
        $maxY = max($maxY, $this->getY());

        $this->setXY(10 + $w1 + $w2, $secondY);
        $this->MultiCell($w3, $h, $this->contents->receiptNo, 0, 'C');
        $maxY = max($maxY, $this->getY());

        $this->setXY(10 + $w1 + $w2 + $w3, $secondY);
        $this->MultiCell($w4, $h, $this->contents->receiptDate, 0, 'C');
        $maxY = max($maxY, $this->getY());

        $boxHeight = $maxY - $originalY;
        $this->Rect($originalX, $originalY, 190, $boxHeight, 'D');

        $this->Line(10 + $w1, $originalY, 10 + $w1, $maxY);
        $this->Line(10 + $w1 + $w2, $originalY, 10 + $w1 + $w2, $maxY);
        $this->Line(10 + $w1 + $w2 + $w3, $originalY, 10 + $w1 + $w2 + $w3, $maxY);
    }

    public function drawSecondReceiptTable()
    {
        $this->Ln(5);
        $this->font(12); $this->fontType('B');

        $this->SetWidths([150, 40]);
        $this->SetAligns(['L', 'R']);
        $this->setRowMultiCellHeight(10);

        $headerRow = [' Description', 'Amount '];
        $this->Row($headerRow);

        $this->fontType('');
        $this->setCurrencyColumns([false, true]);
        $fill = true;
        foreach ($this->contents->export->details as $item) {
            $row = [];
            $row[] = isset($item['description']) ? ' '.$item['description'] : ' - ';
            $row[] = isset($item['credit_amount']) ? amount($item['credit_amount']).' ' : ' - ';
            $this->setRowMultiCellFill($fill);
            $this->Row($row);
            $fill = !$fill;
        }
        $this->resetCurrencyColumns();
    }

    public function drawAfterGridInfo()
    {
        $this->drawReceiptAmountsRow('Total Paid:', $this->contents->totalPaid);
        $this->drawReceiptAmountsRow('New Balance:', $this->contents->newBalance);
        $this->drawReceiptAmountsRow('Fiscal Year Balance:', $this->contents->fiscalYearBalance);
    }

    public function drawReceiptAmountsRow($text, $amount)
    {
        $this->Ln(5);

        $firstCellWidth = $this->GetPageWidth() - 20 - $this->GetStringWidth($amount)-7;

        $originalX = $this->getX();
        $originalY = $this->getY();

        $this->Cell(0, 10, '', 1, 1, 'R', 1);

        $this->setXY($originalX, $originalY);
        $this->Cell($firstCellWidth, 10, $text, 0, 0, 'R');

        $this->setXY($originalX+$firstCellWidth, $originalY);
        $this->CellAmount(0, 10, $amount.' ', 0, 1, 'R', 0);
    }
}

