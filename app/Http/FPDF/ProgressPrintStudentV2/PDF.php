<?php

namespace App\Http\FPDF\ProgressPrintStudentV2;
use AlphaPDF;

require app_path('Http/FPDF/fpdf181/alpha-fpdf.php');

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

    public function generate($export, $progress)
    {
        $this->setContents(new Contents($export, $progress));
        $this->SetTitle($this->contents->title);
        $this->SetAuthor('Tansycloud');
        $this->loadFonts();

        foreach ($this->contents->students as $student) {
            $this->contents->setStudent($student);

            $this->AddPage();
            $this->drawGrid();
            $this->drawHeader();
            $this->drawGradesTable();
            $this->drawStudentInfo();
            $this->drawAttendanceTable();
            $this->drawSignatures();
            $this->drawLogo();
            $this->drawWatermark();
        }

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

    public function TableHeader($header, $width, $height)
    {
        $initialX = $this->getX();
        $initialY = $this->getY();
        $maxY = $initialY + $height;

        $i = 1;
        // draw header text with top border only
        foreach ($header as $text) {
            $x = $this->getX();
            $y = $this->getY();
            $this->MultiCell($width, $height, $text, 'T', 'C');
            if ($maxY < $this->getY()) {
                $maxY = $this->getY();
            }
            $this->setY($initialY);
            $this->setX($initialX + ($width*$i));
            $i++;
        }

        // draw header grid lines
        $this->setXY($initialX, $initialY);
        for ($i=0; $i<=count($header); $i++) {
            $xPos = $initialX + ($width*$i);
            $this->Line($xPos, $initialY, $xPos, $maxY);
        }

        // draw bottom line of row
        $x = $initialX + ($width * count($header));
        $this->Line($initialX, $maxY, $x, $maxY);
        $this->setY($maxY);
    }

    public function drawGradesTable()
    {
        $fontSize = 9;
        $nrTestColumns = count($this->contents->examTypes());
        $nrColumns = 3 + $nrTestColumns;
        $totalWidth = 200;
        $width = round($totalWidth / $nrColumns, 2);

        $this->setXY(12, 36);
        $this->SetFont('Helvetica', 'B', $fontSize);

        $header = ['Subject'];
        foreach ($this->contents->examTypes() as $type) {
            $header[] = $type;
        }
        $header[] = 'Total';
        $header[] = 'Subject Grade Point';

        $startY = 36;
        $this->TableHeader($header, $width, 6);
        $headerHeight = $this->getY() - $startY;

        $nrRows = count($this->contents->getStudent());
        $height = round((102 - $headerHeight) / $nrRows, 2);

        $this->SetFont('Helvetica', '');
        $fill = false;
        foreach ($this->contents->getStudent() as $subject) {
            $this->setX(12);
            $fill = !$fill;

            $this->SetFont('Helvetica', 'B');
            $subjectName = isset($subject['subject_name']) ? $subject['subject_name'] : '';
            $this->Cell($width, $height, $subjectName, 1, 0, 'C', $fill);

            $this->SetFont('Helvetica', '');
            foreach($this->contents->examTypes() as $type) {
                $subjectType = isset($subject[$type]) ? $subject[$type] : '';
                $this->Cell($width, $height, $subjectType, 1, 0, 'C', $fill);
            }

            $subjectMaxTotal = isset($subject['student_subject_max_total']) ? $subject['student_subject_max_total'] : '';
            $this->Cell($width, $height, $subjectMaxTotal, 1, 0, 'C', $fill);

            $subjectGpa = isset($subject['subject_gpa']) ? $subject['subject_gpa'] : '';
            $this->Cell($width, $height, $subjectGpa, 1, 0, 'C', $fill);

            $this->Ln();
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

        $imgPath = public_path('dashboard/student.png');
        $id = $this->contents->studentId;
        $extensionPath = storage_path('uploads/'.domain()."/student-images/{$id}");

        if (file_exists($extensionPath)) {
            $extension = file_get_contents($extensionPath);
            $extension = trim($extension);
            if (file_exists($extensionPath.'.'.$extension)) {
                $imgPath = $extensionPath.'.'.$extension;
            }
        }
        dd($extensionPath);

        $this->Image($imgPath, 214, 36, 30);

        $this->SetFont('Helvetica', 'BU', 11);
        $text  = "\n" . $this->contents->studentName;
        $text .= "\n" . $this->contents->className;
        $text .= "\nRoll.No. " . $this->contents->rollNr;
        $text .= "\nAdm.No. " . $this->contents->admissionNr;

        $this->MultiCell(39, 5, $text, 0, 'L');
    }

    public function drawAttendanceTable()
    {
        $this->setXY(214, 72);
        $this->SetFont('Helvetica', 'B', 12);
        $this->Cell(71, 15, 'ATTENDANCE DETAILS', 1, 1, 'C', true);

        $this->setX(214);
        $y = $this->getY();
        $this->Cell(23, 15, 'Month', 1, 0, 'C');
        $this->Cell(24, 15, '', 1, 0, 'C');
        $this->Cell(24, 15, '', 1, 0, 'C');

        $this->setX(214+23);
        $this->Cell(24, 7, 'Working', 0, 0, 'C');
        $this->Cell(24, 7, 'Days', 0, 1, 'C');

        $this->setX(214+23);
        $this->Cell(24, 7, 'Days', 0, 0, 'C');
        $this->Cell(24, 7, 'Present', 0, 0, 'C');
        $this->Ln(1);

        $this->setY($y+15);

        foreach ($this->contents->months as $month) {
            $calendarMonth = isset($month['calendar_month']) ? $month['calendar_month'] : '';
            $workingDays = isset($month['working_days']) ? $month['working_days'] : '';
            $presentDays = isset($month['present_days']) ? $month['present_days'] : '';

            $this->setX(214);
            $this->Cell(23, 10, $calendarMonth, 1, 0, 'C');
            $this->SetFont('Helvetica', '');
            $this->Cell(24, 10, $workingDays, 1, 0, 'C');
            $this->Cell(24, 10, $presentDays, 1, 1, 'C');
            $this->SetFont('Helvetica', 'B');
        }
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

    public function drawLogo()
    {
        $this->SetAlpha(0.2);

        $logo = storage_path('uploads/'.domain().'/school-logo/logo.png');
        if (!file_exists($logo)) {
            $logo = public_path('images/school-logo.png');
        }

        $this->Image($logo, 97, 76, 40);
        $this->SetAlpha(1);
    }

    public function drawWatermark()
    {
        $this->SetAlpha(0.2);
        $this->RotatedText(110, 135, $this->contents->schoolName, 45);
        $this->SetAlpha(1);
    }
}

