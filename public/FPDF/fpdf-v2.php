<?php

require('fpdf181/fpdf.php');

class Contents
{
    public $title = 'Progress Student V2';

    public $schoolName = 'CANADIAN INTERNATIONAL SCHOOL - RELEASE2S';

    public $phoneNr = '880-193-3344';

    public $examName = 'FA1';
}

class PDF extends FPDF
{
    protected $contents;

    public function setContents($contents)
    {
        $this->contents = $contents;
    }

    public static function portrait()
    {
        // A4 = 210 × 297 millimeters
        return new static('P', 'mm', 'A4');
    }

    public static function landscape()
    {
        // A4 = 297 x 210 millimeters
        return new static('L', 'mm', 'A4');
    }

    public function init()
    {
        $this->setContents(new Contents);
        $this->SetTitle($this->contents->title);
        $this->SetAuthor('Tansycloud');
        $this->loadFonts();

        $this->AddPage();
        $this->drawGrid();
        $this->drawHeader();
        $this->drawBody();
        $this->drawSignatures();
        $this->Output();
    }

    public function loadFonts()
    {
        // $this->AddFont('Helvetica Neue', 'B', 'HelveticaNeueBd.php');
    }

    public function drawGrid()
    {
        $this->SetDrawColor(221, 221, 221);
        $this->SetFillColor(245, 245, 245);
        $this->Rect(10, 10, $this->GetPageWidth()-20, 24, 'F');
        $this->Rect(10, 10, $this->GetPageWidth()-20, $this->GetPageHeight()-50, 'D');
        $this->Line(10, 34, $this->GetPageWidth()-10, 34);
    }

    public function drawHeader()
    {
        $this->SetFont('Helvetica', 'B', 13.5);
        $this->SetTextColor(51, 51, 51);
        $this->Ln(2);
        $this->Cell(0, 5, $this->contents->schoolName, 0, 1, 'C');

        $this->SetFontSize(10.5);
        $this->Cell(0, 4, $this->contents->phoneNr, 0, 1, 'C');
        $this->Ln(3);

        $this->SetFontSize(12);
        $this->Cell(0, 4, $this->contents->examName, 0, 1, 'C');
        $this->Cell(0, 4, 'RESULT SHEET', 0, 1, 'C');
    }

    public function drawBody()
    {

    }

    public function drawSignatures()
    {
        $y = $this->GetPageHeight() - 28;
        $this->setXY(10, $y);
        $width = floor(($this->GetPageWidth() - 20) / 3.0);
        $this->Cell($width, 4, 'Principal Signature', 0, 0, 'C');
        $this->Cell($width, 4, 'Teacher Signature', 0, 0, 'C');
        $this->Cell($width, 4, 'Parent Signature', 0, 0, 'C');
    }
}

$pdf = PDF::landscape();
$pdf->init();
