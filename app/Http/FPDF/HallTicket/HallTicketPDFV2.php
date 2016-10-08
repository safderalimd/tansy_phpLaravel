<?php

namespace App\Http\FPDF\HallTicket;
use BasePDF;

require app_path('Http/FPDF/fpdf181/base-fpdf.php');

class HallTicketPDFV2 extends BasePDF
{
    protected $marginBottom = 10;

    public function generate($export)
    {
        $this->setContents(new HallTicketContents($export));
        $this->SetTitle('Hall Ticket');
        $this->AddFont('Review', 'B', 'Review.php');

        $i = 1;
        foreach($this->contents->tickets as $ticket) {

            if ($i == 4) {
                $i = 1;
            }

            if ($i == 1) {
                $this->AddPage();
            }

            $this->contents->setTicket($ticket);

            $this->drawTicketBorder($i);

            if ($this->contents->showImage()) {
                $this->drawStudentImage();
            }

            $this->drawSchoolHeaderLargeFontHallTicket();
            $this->drawFiltersInfo();
            $this->drawTicketTable();
            $this->drawSignature();
            $this->drawWatermark();

            $i++;
        }

        $this->Output();
        die();
    }

    public function drawTicketBorder($i)
    {
        $this->SetDrawColor(221, 221, 221);
        $this->SetFillColor(245, 245, 245);

        $this->setX(10);
        if ($i == 1) {
            $this->setY(10);
        } elseif ($i == 2) {
            $this->setY(105);
        } elseif ($i == 3) {
            $this->setY(200);
        }
        $this->Rect(10, $this->getY(), $this->GetPageWidth()-20, 85, 'D');
    }

    public function drawFiltersInfo()
    {
        $this->Ln(1);

        $this->SetFont('Helvetica', 'BU', 13);
        $this->setX(12);
        $this->Cell(0, 5, 'Hall Ticket #' . $this->contents->hallTicketNr, 0, 1, 'L');

        $this->SetFont('Helvetica', '', 10);
        $this->setX(12);
        $this->Cell(0, 5, $this->contents->examName . ' ('.$this->contents->fiscalYear.')', 0, 1, 'L');
        $this->setX(12);
        $this->Cell(0, 5, 'Student: ' . $this->contents->studentName, 0, 1, 'L');

        $text = 'Class: ' . $this->contents->className . ', Roll No: ' . $this->contents->rollNumber;
        $this->setX(12);
        $this->Cell(0, 5, $text, 0, 1, 'L');
    }

    public function drawStudentImage()
    {
        $this->showStudentProfilePicture($this->contents->studentId, 160, $this->getY() + 15);
    }

    public function drawTicketTable()
    {
        $nrColumns = count($this->contents->datesRow);
        $cellWidth = round(($this->GetPageWidth() - 24)/$nrColumns, 2);

        $widths = [];
        $emptyRow = [];
        for ($i=0; $i < $nrColumns; $i++) {
            $widths[] = $cellWidth;
            $emptyRow[] = '';
        }
        $this->SetWidths($widths);

        $this->SetFont('Helvetica', '', 10);
        if ($nrColumns > 8) {
            $this->SetFont('Helvetica', '', 8);
        }

        $this->setX(12);
        foreach ($this->contents->datesRow as $cell) {
            $this->Cell($cellWidth, 4, $cell, 'TLR', 0, 'C');
        }
        $this->Ln();

        $this->setX(12);
        foreach ($this->contents->hoursRows as $cell) {
            $this->Cell($cellWidth, 4, $cell, 'LR', 0, 'C');
        }
        $this->Ln();

        $this->setX(12);
        foreach ($this->contents->weekdaysRow as $cell) {
            $this->Cell($cellWidth, 4, $cell, 'BLR', 0, 'C');
        }
        $this->Ln();

        $this->setX(12);
        $this->Row($emptyRow);

        $this->setX(12);
        $this->Row($this->contents->subjectsRow);

        $this->SetFont('Helvetica', '', 10);
    }

    public function drawSignature()
    {
        $this->SetFont('Helvetica', '', 11);
        $this->Ln(3);
        $this->setX(12);
        $this->Cell($this->GetPageWidth() - 24, 6, 'Principal Signature', 0, 1, 'R');
    }

    public function drawWatermark()
    {
        $initialX = $this->getX();
        $initialY = $this->getY();

        $logoWidth = 40;
        $logo = logo_path();

        $x = ($this->GetPageWidth() - $logoWidth)/2;
        $size = GetImageSize($logo);
        $width = isset($size[0]) ? $size[0] : 0;
        $height = isset($size[1]) ? $size[1] : 0;
        $ratio = $width / $height;
        $logoHeight = $logoWidth / $ratio;

        $y = $this->getY() - $logoHeight - 20;

        $this->SetAlpha(0.2);
        $this->Image($logo, $x, $y, $logoWidth);

        $this->setXY(10, $y+$logoHeight+1);
        $this->Cell(0, 6, $this->contents->schoolName, 0, 1, 'C');

        if (isset($this->contents->website)) {
            $this->setXY(10, $y+$logoHeight+7);
            $this->Cell(0, 6, $this->contents->website, 0, 1, 'C');
        }

        $this->SetAlpha(1);

        $this->setXY($initialX, $initialY);
    }
    public function drawSchoolHeaderLargeFontHallTicket()
    {
        $this->AddFont('Review', 'B', 'Review.php');
        $this->SetFont('Review', 'B', 23);

        $this->SetTextColor(51, 51, 51);
        $titleWidth = $this->GetStringWidth($this->contents->schoolName);
        $tableWidth = $this->GetPageWidth()-20;
        while ($titleWidth > $tableWidth) {
            $titleFont -= 2;
            $this->SetFont('Review', 'B', $titleFont);
            $titleWidth = $this->GetStringWidth($this->contents->schoolName);
        }

        // $this->Ln(1);
        $this->Cell(0, 12, $this->contents->schoolName, 0, 1, 'C');

        // line 2
        $this->SetFont('Helvetica', 'B', 12);
        if (empty($this->contents->headerSecondLine)) {
            $this->Ln(2);
        } else {
            $this->Cell(0, 4, $this->contents->headerSecondLine, 0, 1, 'C');
        }
        $this->Ln(1);

        // line 3
        if (empty($this->contents->headerThirdLine)) {
            $this->Ln(2);
        } else {
            $this->Cell(0, 4, $this->contents->headerThirdLine, 0, 1, 'C');
        }

        $this->Ln(1);
        $this->SetFont('Helvetica', 'B', 15);
        $this->Cell(0, 6, $this->contents->reportName, 0, 1, 'C');
    }
}

