<?php

namespace App\Http\FPDF\ProgressPrintStudentV2;
use BasePDF;

require app_path('Http/FPDF/fpdf181/base-fpdf.php');

class V4PDF extends BasePDF
{
    public function generate($export, $progress)
    {
        $this->setContents(new V3Contents($export, $progress));
        $this->SetTitle($this->contents->title);
        $this->SetAuthor('Tansycloud');

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
            $this->drawGraph();
        }

        $this->Output();
    }

    public function drawGrid()
    {
        $this->SetDrawColor(221, 221, 221);
        $this->SetFillColor(245, 245, 245);
        $this->Rect(10, 10, $this->GetPageWidth()-20, 36, 'F');
        $this->Rect(10, 10, $this->GetPageWidth()-20, $this->GetPageHeight()-50, 'D');
        $this->Line(10, 46, $this->GetPageWidth()-10, 46);
    }

    public function drawHeader()
    {
        $titleFont = 50;
        $this->AddFont('Review', 'B', 'Review.php');
        $this->SetFont('Review', 'B', $titleFont);

        $this->SetTextColor(51, 51, 51);
        $titleWidth = $this->GetStringWidth($this->contents->schoolName);
        $tableWidth = $this->GetPageWidth()-20;
        while ($titleWidth > $tableWidth) {
            $titleFont -= 2;
            $this->SetFont('Review', 'B', $titleFont);
            $titleWidth = $this->GetStringWidth($this->contents->schoolName);
        }

        $this->Ln(2);
        $this->Cell(0, 15, $this->contents->schoolName, 0, 1, 'C');

        // line 2
        $this->SetFont('Times', 'B', 12);
        if (empty($this->contents->progress->headerSecondLine)) {
            $this->Ln(4);
        }
        $this->Cell(0, 4, $this->contents->progress->headerSecondLine, 0, 1, 'C');
        $this->Ln(2);

        // line 3
        $this->Cell(0, 4, $this->contents->progress->headerThirdLine, 0, 1, 'C');
        if (empty($this->contents->progress->headerThirdLine)) {
            $this->Ln(4);
        }
        $this->Ln(2);

        $this->SetFont('Helvetica', 'B', 12);
        $this->Cell(0, 4, 'PROGRESS REPORT - ' . $this->contents->examName, 0, 1, 'C');
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

        $this->setXY(12, 48);
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
        $this->setXY(214, 48);
        $this->Cell(32, 35, '', 0, 0, 'C');

        $imgPath = student_picture_path($this->contents->studentId);
        $this->Image($imgPath, 214, 48, 30);

        $this->SetFont('Helvetica', 'BU', 11);
        $text  = "\n" . $this->contents->studentName;
        $text .= "\n" . $this->contents->className;
        $text .= "\nRoll.No. " . $this->contents->rollNr;
        $text .= "\nAdm.No. " . $this->contents->admissionNr;

        $this->MultiCell(39, 5, $text, 0, 'L');
    }

    public function drawAttendanceTable()
    {
        $this->setXY(214, 130);
        $this->SetFont('Helvetica', 'B', 12);
        $this->Cell(71, 8, 'ATTENDANCE DETAILS', 0, 1, 'L');

        $this->SetFont('Helvetica', '', 11);
        $i = 1;
        foreach ($this->contents->months as $month) {
            $calendarMonth = isset($month['calendar_month']) ? $month['calendar_month'] : '';
            $workingDays = isset($month['working_days']) ? $month['working_days'] : '';
            $presentDays = isset($month['present_days']) ? $month['present_days'] : '';

            // show second column of dates coordinates
            if ($i == 7) {
                $this->setY(140);
            }
            if ($i >= 7) {
                $this->setX(249);
            } else {
                $this->setX(214);
            }

            $text = $calendarMonth . ' ' . $presentDays . '/' . $workingDays;
            $this->Cell(35, 5, $text, 0, 1, 'L');

            $i++;
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
        $this->SetFont('Helvetica', 'B', 12);
        $this->SetAlpha(0.2);
        $this->RotatedText(110, 135, $this->contents->schoolName, 45);
        $this->SetAlpha(1);
    }

    public function drawGraph()
    {
        // data
        // $maxMark = $this->contents->maxMark;
        // $this->getIncrements($maxMark);
        $increments = [100, 80, 60, 40, 20, 0];
        $percentages = $this->contents->percentages;
        $percentagesLine = $this->contents->percentagesLine;

        $subjects = $this->contents->subjects;
        $nrSubjects = count($subjects);

        // colors
        $this->SetDrawColor(119, 119, 119);
        $this->SetFillColor(0, 69, 138);
        $this->SetFont('Helvetica', '', 7);
        $this->SetTextColor(51, 51, 51);

        // coordinates
        $this->setXY(214, 84);

        $width = 71; // total width of the graph + left labels
        $cellHeight = 7; // the height of left labels
        $cellWidth = 5; // the width of left labells
        $nrLines = 6; // nr horizontal lines
        $halfCellHeight = round($cellHeight/2, 2); // half of left labels height
        $lineExtra = 1; // offset for lines
        $graphWidth = $width - $cellWidth - $lineExtra; // total width of only the graph without left labels
        $colWidth = round($graphWidth/$nrSubjects, 2); // the width of a column (distance beteween 2 lines at the bottom)
        $barWidth = round($colWidth - (50/100) * $colWidth, 2); // width of blue bar
        $barOffset = round(($colWidth - $barWidth)/2, 2); // blue bar offset
        $graphHeight = ($nrLines-1) * $cellHeight;
        $halfBarWidth = round($barWidth/2, 2);

        // original coordinates
        $x = $this->getX();
        $y = $this->getY();

        // the y coordinates of base line of the graph
        $baseLine = $y + $cellHeight * ($nrLines-1) + $halfCellHeight;

        // draw horizontal graph lines and left labels
        for ($i = 0; $i < $nrLines; $i++) {
            $this->setX($x);
            $this->Cell($cellWidth, $cellHeight, $increments[$i], 0, 1, 'R');

            $x1 = $x + $cellWidth;
            $y1 = $y + $cellHeight*$i + $halfCellHeight;
            $x2 = $x + $width;
            $y2 = $y + $cellHeight*$i + $halfCellHeight;

            $this->Line($x1, $y1, $x2, $y2);
        }

        // draw first and last vertical graph lines
        $x1 = $x + $cellWidth + $lineExtra;
        $y1 = $y + $halfCellHeight;
        $y2 = $y + $halfCellHeight + $cellHeight*($nrLines-1) + $lineExtra;
        $this->Line($x1, $y1, $x1, $y2);
        $x1 = $x + $width;
        $this->Line($x1, $y1, $x1, $y2);

        // draw spikes extra lines at the bottom (except first and last ones)
        for ($i=1; $i<$nrSubjects; $i++) {
            $x1 = $x + $colWidth * $i + $cellWidth + $lineExtra;
            $x2 = $x1;
            $y1 = $baseLine;
            $y2 = $y1 + $lineExtra;

            $this->Line($x1, $y1, $x2, $y2);
        }

        // draw subject labels
        $x1 = $x + $cellWidth + $lineExtra;
        $y1 = $baseLine;
        $this->setXY($x1, $y1);
        for ($i=0; $i<$nrSubjects; $i++) {
            $this->Cell($colWidth, $cellHeight, $subjects[$i], 0, 0, 'C');
        }

        // draw bars on graph
        for ($i=0; $i<$nrSubjects; $i++) {
            $x1 = $x + $colWidth * $i + $lineExtra + $cellWidth + $barOffset;
            $y1 = $baseLine;

            $barHeight = round($percentages[$i]/100 * $graphHeight, 2);
            $this->Rect($x1, $y1, $barWidth, -1 * $barHeight, 'F');
        }

        // draw red line on graph
        $this->SetDrawColor(203, 70, 41);
        for ($i=0; $i<$nrSubjects-1; $i++) {

            $x1 = $x + $colWidth * $i + $lineExtra + $cellWidth + $barOffset + $halfBarWidth;
            $x2 = $x1 + $colWidth;

            $line1Height = round($percentagesLine[$i]/100 * $graphHeight, 2);
            $line2Height = round($percentagesLine[$i+1]/100 * $graphHeight, 2);
            $y1 = $baseLine - $line1Height;
            $y2 = $baseLine - $line2Height;

            $this->Line($x1, $y1, $x2, $y2);
        }
    }

    // return 6 elements in the array
    // public function getIncrements($maxMark)
    // {
    //     return [
    //         round($maxMark),
    //         round(80/100 * $maxMark),
    //         round(60/100 * $maxMark),
    //         round(40/100 * $maxMark),
    //         round(20/100 * $maxMark),
    //         0,
    //     ];
    // }
}

