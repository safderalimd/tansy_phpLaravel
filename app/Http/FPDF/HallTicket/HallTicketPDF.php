<?php

namespace App\Http\FPDF\HallTicket;
use BasePDF;

require app_path('Http/FPDF/fpdf181/base-fpdf.php');

class HallTicketPDF extends BasePDF
{
    protected $marginBottom = 10;

    public function generate($export)
    {
        $this->setContents(new HallTicketContents($export));
        $this->SetTitle('Hall Ticket');
        $this->SetAuthor('Tansycloud');

        $this->initDrawColors();

        $i = 1;
        foreach($this->contents->tickets as $ticket) {

            if ($i == 4) {
                $i = 1;
            }

            if ($i == 1) {
                $this->AddPage();
            }

            $initialX = $this->getX();
            $initialY = $this->getY();

            $this->contents->setTicket($ticket);

            if ($this->contents->showImage()) {
                $this->drawStudentImage();
            }

            $this->drawHeader();
            $this->drawTicketTable();
            $this->drawSignature();
            $this->drawWatermark();

            // draw ticket border
            $this->Rect($initialX, $initialY, $this->GetPageWidth()-20, $this->getY()-$initialY, 'D');
            // $nrLines = $this->nrLines();

            $this->Ln(5);

            $i++;
        }

        $this->Output();
        die();
    }

    public function initDrawColors()
    {
        $this->SetDrawColor(221, 221, 221);
        $this->SetFillColor(245, 245, 245);
    }

    public function drawHeader()
    {
        $this->SetFont('Helvetica', 'B', 15);
        $this->SetTextColor(51, 51, 51);
        $this->Ln(5);
        $this->Cell(0, 5, $this->contents->schoolName, 0, 1, 'C');

        $text = $this->contents->schoolCity . ' (Phone: ' . $this->contents->schoolWorkPhone . ')';
        $this->SetFont('Helvetica', '', 10);
        $this->Cell(0, 5, $text, 0, 1, 'C');
        $this->Ln(8);

        $this->SetFont('Helvetica', 'BU', 14);
        $this->setX(12);
        $this->Cell(0, 5, 'Hall Ticket - ' . $this->contents->fiscalYear, 0, 1, 'L');

        $this->SetFont('Helvetica', '', 10);
        $this->setX(12);
        $this->Cell(0, 5, 'Exam: ' . $this->contents->examName, 0, 1, 'L');
        $this->setX(12);
        $this->Cell(0, 5, 'Student: ' . $this->contents->studentName, 0, 1, 'L');

        $text = 'Class: ' . $this->contents->className . ', Roll No: ' . $this->contents->rollNumber;
        $this->setX(12);
        $this->Cell(0, 5, $text, 0, 1, 'L');
    }

    public function drawStudentImage()
    {
        $x = $this->getX();
        $y = $this->getY();

        $imgPath = student_picture_path($this->contents->studentId);
        $this->Image($imgPath, 160, $y + 10, 30);

        $this->setXY($x, $y);
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

        $this->Ln(3);
        $this->SetFont('Helvetica', '', 10);

        $this->setX(12);
        foreach ($this->contents->datesRow as $cell) {
            $this->Cell($cellWidth, 5, $cell, 'TLR', 0, 'C');
        }
        $this->Ln();

        $this->setX(12);
        foreach ($this->contents->weekdaysRow as $cell) {
            $this->Cell($cellWidth, 5, $cell, 'BLR', 0, 'C');
        }
        $this->Ln();

        $this->setX(12);
        $this->Row($this->contents->subjectsRow);

        $this->setX(12);
        $this->Row($emptyRow);
    }

    public function drawSignature()
    {
        $this->SetFont('Helvetica', '', 11);
        $this->Ln(1);
        $this->setX(12);
        $this->Cell($this->GetPageWidth() - 24, 6, 'Principal Signature', 0, 1, 'R');
        $this->Ln(7);
    }

    public function drawWatermark()
    {
        $y = $this->getY();
        $this->SetAlpha(0.2);
        $this->RotatedText(60, $this->getY()-4, $this->contents->schoolName, 45);
        $this->SetAlpha(1);
        $this->setY($y);
    }
}

