<?php

require('fpdf181/fpdf.php');

class Contents
{
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

    public static function drawProgressStudentV2()
    {
        $pdf = PDF::landscape();
        $pdf->loadFonts();
        $pdf->setContents(new Contents);
        $pdf->AddPage();
        $pdf->drawHeader();
        $pdf->Output();
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

    public function loadFonts()
    {
        $this->AddFont('Helvetica Neue', 'B', 'HelveticaNeueBd.php');
    }

    public function drawHeader()
    {
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(0, 18, $this->contents->schoolName, 1, 1, 'C');

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 12, $this->contents->phoneNr, 1, 1, 'C');

        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 15, $this->contents->examName, 1, 1, 'C');

        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 15, 'RESULT SHEET', 1, 1, 'C');
    }

}

PDF::drawProgressStudentV2();
