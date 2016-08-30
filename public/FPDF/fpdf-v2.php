<?php

require('fpdf181/alpha-fpdf.php');

// Contents for each student row
class Contents
{
    public $title = 'Progress Student V2';

    public $schoolName = 'CANADIAN INTERNATIONAL SCHOOL - RELEASE2S';

    public $phoneNr = '880-193-3344';

    public $examName = 'FA1';

    public $grandTotal = 84.44;

    public $percentage = 95.44;

    public $grade = 'A2';

    public $gpa = '9.00';
}

class PDF extends AlphaPDF
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
        $this->drawGradesTable();
        $this->drawStudentInfo();
        $this->drawAttendanceTable();
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

        $this->SetAlpha(0.2);
        $this->Image('logo.png', 10, 6, 30);
        $this->SetAlpha(1);
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

    public function drawGradesTable()
    {
        $fontSize = 9;
        $nrTestColumns = 4;
        $nrColumns = 3 + $nrTestColumns;
        $totalWidth = 200;
        $width = round($totalWidth / $nrColumns, 2);

        $nrRows = 10;
        $height = round(102 / $nrRows, 2);

        $this->setXY(12, 36);
        $this->SetFont('Helvetica', '', $fontSize);

        $fill = false;
        for ($line = 0; $line < $nrRows; $line++) {
            for ($i=0; $i<$nrColumns; $i++) {
                $this->Cell($width, $height, $i, 1, 0, 'C', $fill);
            }
            $fill = !$fill;
            $this->Ln();
            $this->setX(12);
        }

        // remarks cell
        $y = $this->getY();
        $this->SetFont('Helvetica', 'BU', 11);
        $this->Cell($width * $nrTestColumns, 9, 'Remarks', 0, 0, 'C');
        $this->setY($y);
        $this->setX(12);
        $this->Cell($width * $nrTestColumns, 30, '', 1, 0, 'C');

        // grand total text cell
        $this->SetFont('Helvetica', 'B', $fontSize);
        $this->Cell($width, 10, 'GRAND TOTAL', 1, 0, 'C', true);

        // grand total value
        $this->SetFont('Helvetica', '');
        $this->Cell($width, 10, $this->contents->grandTotal, 1, 0, 'C', true);

        // gpa text cell
        $this->SetFont('Helvetica', 'B');
        $this->Cell($width, 10, 'GPA', 1, 1, 'C', true);

        // percentage text cell
        $y = $this->getY();
        $this->setX(12 + $width * $nrTestColumns);
        $this->Cell($width, 10, 'PERCENTAGE', 1, 0, 'C');

        // percentage value
        $this->SetFont('Helvetica', '');
        $this->Cell($width, 10, $this->contents->percentage, 1, 1, 'C');

        // grade text cell
        $this->setX(12 + $width * $nrTestColumns);
        $this->SetFont('Helvetica', 'B');
        $this->Cell($width, 10, 'GRADE', 1, 0, 'C', true);

        // grade value
        $this->SetFont('Helvetica', '');
        $this->Cell($width, 10, $this->contents->grade, 1, 1, 'C', true);

        // gpa value
        $this->setY($y);
        $this->setX(12 + $width * ($nrTestColumns+2));
        $this->Cell($width, 20, $this->contents->gpa, 1, 1, 'C', true);
    }

    public function drawStudentInfo()
    {
        $this->setXY(214, 36);
        $this->Cell(32, 35, '', 0, 0, 'C');
        $this->Image('student.png', 214, 36, 30);

        $this->SetFont('Helvetica', 'BU', 12);
        $text = "\nJohn Doe\nX-A\nRoll.No. 1\nAdm.No. 23";
        $this->MultiCell(39, 5, $text, 0, 'L');
    }

    public function drawAttendanceTable()
    {
        $this->setXY(214, 72);
        $this->SetFont('Helvetica', 'B', 12);
        $this->Cell(71, 15, 'ATTENDANCE DETAILS', 1, 1, 'C', true);

        $this->setX(214);
        // $this->MultiCell(24, 7, "Month", 1, 'C');
        // $this->MultiCell(24, 7, "Working\nDays", 1, 'C');


        $this->Cell(23, 15, 'Month', 1, 0, 'C');
        $this->Cell(24, 15, '', 1, 0, 'C');
        $this->Cell(24, 15, '', 1, 0, 'C');

        $this->setX(214+23);
        $this->Cell(24, 7, 'Working', 0, 0, 'C');
        $this->Cell(24, 7, 'Days', 0, 1, 'C');

        $this->setX(214+23);
        $this->Cell(24, 7, 'Days', 0, 0, 'C');
        $this->Cell(24, 7, 'Present', 0, 0, 'C');
    }

    public function drawSignatures()
    {
        $this->SetFont('Helvetica', 'B', 13.5);
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
