<?php

namespace App\Http\FPDF\ProgressPrintStudentV2;
use BasePDF;

require app_path('Http/FPDF/fpdf181/base-fpdf.php');

class V6PDF extends BasePDF
{
    protected $website;

    public function generate($export, $progress)
    {
        $export->setOwnerOrganizationInfo();
        $this->website = $export->organizationWebsite();
        $this->setContents(new V3Contents($export, $progress));
        $this->SetTitle($this->contents->title);
        $this->SetAuthor('Tansycloud');

        foreach ($this->contents->students as $student) {
            $this->contents->setStudent($student);

            $this->AddPage();
            $this->drawGrid();
            $this->drawHeader();
            $this->drawGradesTable();
            $this->drawCocuricularTable();
            $this->drawStudentInfo();
            $this->drawAttendanceTable();
            $this->drawSignatures();
            $this->drawWatermark();
            $this->drawGraph();
        }

        $this->Output();
    }

    public function hexColor($name)
    {
        $colors = $this->contents->progress->colors;

        $color = $colors->first(function ($key, $value) use ($name) {
            if (!isset($value['header']) || !isset($value['hex_color_code'])) {
                return false;
            }

            if ($name == $value['header']) {
                return true;
            }

            return false;
        });

        if (!empty($color['header'])) {
            $hex = $color['hex_color_code'];
            if (empty($hex)) {
                $hex = '#000000';
            }
            if (strpos($hex, '##') !== false) {
                $hex = str_replace('##', '#', $hex);
            }

            list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
            return [$r, $g, $b];
        }

        return [245, 245, 245];
    }

    public function setBackgroundColor($name)
    {
        $rgb = $this->hexColor($name);
        $this->SetFillColor($rgb[0], $rgb[1], $rgb[2]);
    }

    public function resetBackgroundColor()
    {
        $this->SetFillColor(245, 245, 245);
    }

    public function setHexFontColor($name)
    {
        $rgb = $this->hexColor($name);
        $this->SetTextColor($rgb[0], $rgb[1], $rgb[2]);
    }

    public function resetHexFontColor()
    {
        $this->SetTextColor(51, 51, 51);
    }

    public function drawGrid()
    {
        $this->SetLineWidth(0.1);
        $this->SetDrawColor(221, 221, 221);
        $this->setBackgroundColor("REPORT TOP HEADER");
        $this->Rect(10, 10, $this->GetPageWidth()-20, 36, 'F');
        $this->Rect(10, 10, $this->GetPageWidth()-20, $this->GetPageHeight()-50, 'D');
        $this->Line(10, 46, $this->GetPageWidth()-10, 46);
        $this->resetBackgroundColor();
    }

    public function drawHeader()
    {
        $titleFont = 45;
        $this->AddFont('Review', 'B', 'Review.php');
        $this->SetFont('Review', 'B', $titleFont);

        $this->setHexFontColor('REPORT TOP HEADER FONT COLOR');
        $titleWidth = $this->GetStringWidth($this->contents->schoolName);
        $tableWidth = $this->GetPageWidth()-20;
        while ($titleWidth > $tableWidth) {
            $titleFont -= 2;
            $this->SetFont('Review', 'B', $titleFont);
            $titleWidth = $this->GetStringWidth($this->contents->schoolName);
        }

        $this->Ln(2);
        $this->Cell(0, 14, $this->contents->schoolName, 0, 1, 'C');

        // line 2
        $this->SetFont('Helvetica', 'B', 12);
        if (empty($this->contents->progress->headerSecondLine)) {
            $this->Ln(4);
        } else {
            $this->Cell(0, 4, $this->contents->progress->headerSecondLine, 0, 1, 'C');
        }
        $this->Ln(2);

        // line 3
        if (empty($this->contents->progress->headerThirdLine)) {
            $this->Ln(4);
        } else {
            $this->Cell(0, 4, $this->contents->progress->headerThirdLine, 0, 1, 'C');
        }
        $this->Ln(2);

        $this->SetFont('Helvetica', 'B', 14);
        $this->Cell(0, 5, 'PROGRESS REPORT - ' . $this->contents->examName, 0, 1, 'C');
        $this->resetHexFontColor();
    }

    public function TableHeader($header, $width, $height, $headerColors)
    {
        $initialX = $this->getX();
        $initialY = $this->getY();
        $maxY = $initialY + $height;

        $i = 1;
        // draw header text with top border only
        foreach ($header as $text) {
            $x = $this->getX();
            $y = $this->getY();
            if ($i == 1) {
                $this->MultiCell($this->subjectsColumnWidth, $height, $text, 'T', 'C');
            } else {
                $this->MultiCell($width, $height, $text, 'T', 'C');
            }
            if ($maxY < $this->getY()) {
                $maxY = $this->getY();
            }
            $this->setY($initialY);
            $this->setX($initialX + $this->subjectsColumnWidth + ($width*($i-1)) );                
            $i++;
        }

        if ($maxY <= $initialY+$height) {
            $maxY += $height;
            $height = 2*$height;
        }

        // draw the background colors
        $this->setXY($initialX, $initialY);
        $colorIndex = 0;
        $i = 1;
        $h = $maxY - $initialY;
        foreach ($header as $text) {
            $x = $this->getX();
            $y = $this->getY();

            // set color for each cell
            $c = $headerColors[$colorIndex];
            $this->SetFillColor($c[0], $c[1], $c[2]);

            if ($i == 1) {
                $W = $this->subjectsColumnWidth;
            } else {
                $W = $width;
            }

            $this->Rect($x, $y, $W, $h, 'F');
            $this->MultiCell($W, $height, $text, 'T', 'C');

            $this->setY($initialY);
            $this->setX($initialX + $this->subjectsColumnWidth + ($width*($i-1)) );                
            $i++;
            $colorIndex++;
        }
        $this->SetFillColor(245, 245, 245);

        // draw header grid lines
        $this->setXY($initialX, $initialY);
        for ($i=0; $i<=count($header); $i++) {
            if ($i == 0) {
                $xPos = $initialX + $this->subjectsColumnWidth;
            } else {
                $xPos = $initialX + $this->subjectsColumnWidth + ($width*($i-1));
            }
            $this->Line($xPos, $initialY, $xPos, $maxY);
        }

        // draw bottom line of row
        $x = $initialX + ($width * (count($header)-1));
        $this->Line($initialX, $maxY, $x, $maxY);
        $this->setY($maxY);
    }

    protected $subjectsColumnWidth = 30;
    protected $curicularColumnWidth = 70;
    protected $totalLeftTabelWdith = 100;
    protected $gradesRowHeight = 10;
    protected $gradesHeaderRowHeight = 10;

    public function drawCocuricularTable()
    {
        $totalWidth = $this->totalLeftTabelWdith;
        $subjects = $this->contents->coCurricularSubjects;
        $height = round((120 - $this->gradesHeaderRowHeight) / (8+ count($subjects)), 2);

        $xPos = 12+$totalWidth+$this->subjectsColumnWidth;

        // draw co-curicular activities header
        $this->SetFont('Helvetica', 'B', 9);
        $this->setBackgroundColor('Co-Curricular');
        $this->setXY($xPos, 48);
        $text = 'Life Skills Portfolio';
        $this->Cell($this->curicularColumnWidth, $this->gradesHeaderRowHeight, $text, 1, 1, 'C', true);
        $this->resetBackgroundColor();

        $subjectsWidth = 30;
        $w = round(($this->curicularColumnWidth - $subjectsWidth) / (1+count($this->contents->coCuricullarTypes())), 2);
        $this->setX($xPos);

        // curricular subject cell
        $this->setBackgroundColor('Subject');
        $this->Cell($subjectsWidth, $height, 'Skills', 1, 0, 'C', true);
        $this->resetBackgroundColor();

        // coCuricullarTypes
        foreach ($this->contents->coCuricullarTypes() as $type) {
            $this->Cell($w, $height, $type, 1, 0, 'C', true);
        }

        // curricular subject cell
        $this->setBackgroundColor('Grade');
        $this->Cell($w, $height, 'G.P.', 1, 1, 'C', true);
        $this->resetBackgroundColor();

        // find out the max length of a subject, then reduce the fonts to fit the columns
        $maxString = '';
        foreach ($subjects as $subject) {
            $subjectName = isset($subject['exam']) ? $subject['exam'] : '';
            if (strlen($subjectName) > strlen($maxString)) {
                $maxString = $subjectName;
            }
        }
        $subjectFontSize = 9;
        $subjetWidth = $this->GetStringWidth($maxString);
        while ($subjetWidth > $subjectsWidth) {
            $subjectFontSize -= 1;
            $this->SetFontSize($subjectFontSize);
            $subjetWidth = $this->GetStringWidth($maxString);
        }

        // draw subjects and marks
        $sum = 0;
        $subjectsSum = [];
        $nr = count($subjects);
        foreach ($subjects as $subject) {
            $this->setX($xPos);
            $i = 0;

            $subjectName = isset($subject['exam']) ? $subject['exam'] : '';
            $subGpa = isset($subject['sub_gpa']) ? $subject['sub_gpa'] : '';

            $this->SetFont('Helvetica', '', $subjectFontSize);
            $this->Cell($subjectsWidth, $height, $subjectName, 1, 0, 'C', true);

            $this->SetFont('Helvetica', '', 9);
            foreach ($this->contents->coCuricullarTypes() as $type) {
                $mark = isset($subject[$type]) ? $subject[$type] : '';
                $this->Cell($w, $height, $mark, 1, 0, 'C', true);
                if (! isset($subjectsSum[$i])) {
                    $subjectsSum[$i] = 0;
                }
                $subjectsSum[$i] += $mark;
                $i++;
            }
            $sum += $subGpa;
            $this->Cell($w, $height, $subGpa, 1, 1, 'C', true);
        }

        $this->setX($xPos);
        $this->SetFont('Helvetica', 'B', 9);
        $this->setBackgroundColor('Health - Overall GPA');
        $this->Cell($subjectsWidth, $height, 'Total', 1, 0, 'C', true);
        $this->resetBackgroundColor();                
        
        $i = 0;
        foreach ($this->contents->coCuricullarTypes() as $type) {
            $sumForMarks = $subjectsSum[$i] ?? '';
            $this->Cell($w, $height, $sumForMarks, 1, 0, 'C', true);
            $i++;
        }

        $averageGPA = round($sum / $nr, 2);
        $this->Cell($w, $height, $averageGPA, 1, 1, 'C', true);

        // if ($nr != 0) {
        //     $this->setX($xPos);
        //     $averageGPA = round($sum / $nr, 2);
        //     $this->setBackgroundColor('Health - Overall GPA');
        //     $w1 = $this->subjectsColumnWidth + $w * count($this->contents->coCuricullarTypes());
        //     $this->Cell($w1, $height, 'Overall GPA', 1, 0, 'C', true);

        //     $this->resetBackgroundColor();                
        //     $this->Cell($w, $height, $averageGPA, 1, 1, 'C', true);
        // }

        // health checkup
        $this->setX($xPos);
        $this->setBackgroundColor('Health Checkup');
        $this->Cell($this->curicularColumnWidth, $height, 'Health Status and Checkup Details', 1, 1, 'C', true);
        $this->resetBackgroundColor();

        $halfWidth = round($this->curicularColumnWidth/2, 2);

        // date of checkup
        $this->setX($xPos);
        $this->setBackgroundColor('Date of Checkup');
        $this->Cell($halfWidth, $height, 'Date of Checkup', 1, 0, 'C', true);
        $this->resetBackgroundColor();
        $this->Cell($halfWidth, $height, '', 1, 1, 'C', true);

        $this->setX($xPos);
        $this->setBackgroundColor('Health - Height');
        $this->Cell($halfWidth, $height, 'HEIGHT', 1, 0, 'C', true);
        $this->resetBackgroundColor();
        $this->Cell($halfWidth, $height, '', 1, 1, 'C', true);

        $this->setX($xPos);
        $this->setBackgroundColor('Health - Weight');
        $this->Cell($halfWidth, $height, 'WEIGHT', 1, 0, 'C', true);
        $this->resetBackgroundColor();
        $this->Cell($halfWidth, $height, '', 1, 1, 'C', true);

        $this->setX($xPos);
        $this->setBackgroundColor('Health Issues');
        $this->Cell($halfWidth, $height, 'Health Issues', 1, 0, 'C', true);
        $this->resetBackgroundColor();
        $this->Cell($halfWidth, $height, '', 1, 1, 'C', true);

        $this->setX($xPos);
        $this->setBackgroundColor('Health - Suggestions');
        $this->Cell($halfWidth, $height, 'SUGGESTIONS', 1, 0, 'C', true);
        $this->resetBackgroundColor();
        $this->Cell($halfWidth, $height, '', 1, 1, 'C', true);


    }

    public function drawGradesTable()
    {
        $fontSize = 9;
        $nrTestColumns = count($this->contents->examTypes());
        $nrColumns = 2 + $nrTestColumns;
        $totalWidth = $this->totalLeftTabelWdith;
        $width = round($totalWidth / $nrColumns, 2);

        $this->setXY(12, 48);
        $this->SetFont('Helvetica', 'B', $fontSize);

        $headerColors = [];

        $header = ['Subject'];
        $headerColors[] = $this->hexColor('Subject');

        foreach ($this->contents->examTypes() as $type) {
            $headerColors[] = $this->hexColor($type);
            $header[] = $type;
        }
        $header[] = 'Total';
        $headerColors[] = $this->hexColor('Total');
        $header[] = 'GP';
        $headerColors[] = $this->hexColor('Subject Grade Point');

        $startY = 36;
        $this->TableHeader($header, $width, 6, $headerColors);
        $headerHeight = $this->getY() - $startY;
        $this->gradesHeaderRowHeight = $this->getY() - 48;

        $nrRows = count($this->contents->getStudent());
        $height = round((102 - $headerHeight) / $nrRows, 2);
        $this->gradesRowHeight = $height;

        // find out the max length of a subject, then reduce the fonts to fit the columns
        $maxString = '';
        foreach ($this->contents->getStudent() as $subject) {
            $subjectName = isset($subject['subject_name']) ? $subject['subject_name'] : '';
            if (strlen($subjectName) > strlen($maxString)) {
                $maxString = $subjectName;
            }
        }
        $subjectFontSize = $fontSize;
        $subjetWidth = $this->GetStringWidth($maxString);
        while ($subjetWidth > $this->subjectsColumnWidth) {
            $subjectFontSize -= 1;
            $this->SetFontSize($subjectFontSize);
            $subjetWidth = $this->GetStringWidth($maxString);
        }

        // draw the grid
        $this->SetFont('Helvetica', '');
        $fill = false;
        foreach ($this->contents->getStudent() as $subject) {
            $this->setX(12);
            $fill = !$fill;

            $this->SetFont('Helvetica', 'B');
            $this->SetFontSize($subjectFontSize);
            $subjectName = isset($subject['subject_name']) ? $subject['subject_name'] : '';
            $this->Cell($this->subjectsColumnWidth, $height, $subjectName, 1, 0, 'C', $fill);
            $this->SetFontSize($fontSize);

            $this->SetFont('Helvetica', '');
            foreach($this->contents->examTypes() as $type) {
                $subjectType = isset($subject[$type]) ? $subject[$type] : 'AB';
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

        $this->setBackgroundColor('Remarks');
        $W = $this->subjectsColumnWidth + $width * ($nrTestColumns-2);
        $this->Rect(12, $y, $W, 30, 'F');
        $this->Cell($W, 9, 'Remarks', 0, 0, 'C', false);
        $this->setY($y);
        $this->setX(12);
        $this->Cell($W, 30, '', 1, 0, 'C');

        // grand total text cell
        $this->SetFont('Helvetica', 'B', $fontSize);
        $this->setBackgroundColor('GRAND TOTAL');
        $this->Cell($width*2, 10, 'GRAND TOTAL', 1, 0, 'C', true);

        // grand total value
        $this->SetFont('Helvetica', '');
        $this->Cell($width, 10, $this->contents->grandTotal, 1, 0, 'C', true);
        $this->resetBackgroundColor();

        // gpa text cell
        $this->SetFont('Helvetica', 'B');
        $this->setBackgroundColor('GPA');
        $this->Cell($width, 10, 'GPA', 1, 1, 'C', true);
        $this->resetBackgroundColor();

        // percentage text cell
        $y = $this->getY();
        $this->setX(12 + $W);
        $this->setBackgroundColor('PERCENTAGE');
        $this->Cell($width*2, 10, 'PERCENTAGE', 1, 0, 'C', true);

        // percentage value
        $this->SetFont('Helvetica', '');
        $this->Cell($width, 10, $this->contents->percentage, 1, 1, 'C', true);
        $this->resetBackgroundColor();

        // grade text cell
        $this->setX(12 + $W);
        $this->SetFont('Helvetica', 'B');
        $this->setBackgroundColor('GRADE');
        $this->Cell($width*2, 10, 'GRADE', 1, 0, 'C', true);

        // grade value
        $this->SetFont('Helvetica', '');
        $this->Cell($width, 10, $this->contents->grade, 1, 1, 'C', true);
        $this->resetBackgroundColor();

        // gpa value
        $this->setY($y);
        $this->setBackgroundColor('GPA');
        $this->setX(12 + $width*3 + $W); //* ($nrTestColumns+2));
        $this->Cell($width, 20, $this->contents->gpa, 1, 1, 'C', true);
        $this->resetBackgroundColor();
    }

    public function drawStudentInfo()
    {
        $this->setXY(214, 48);
        $this->Cell(32, 35, '', 0, 0, 'C');

        $this->showStudentProfilePicture($this->contents->studentId, 214, 48);

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
        $this->Cell($width, 4, 'Class Teacher Signature', 0, 0, 'C');
        $this->Cell($width, 4, 'Parent Signature', 0, 0, 'C');
    }

    public function drawWatermark()
    {
        $initialX = $this->getX();
        $initialY = $this->getY();

        $x = 97;
        $y = 76;
        $logoWidth = 40;
        $logo = logo_path();

        $size = GetImageSize($logo);
        $width = isset($size[0]) ? $size[0] : 0;
        $height = isset($size[1]) ? $size[1] : 0;
        $ratio = $width / $height;
        $logoHeight = $logoWidth / $ratio;

        $this->SetAlpha(0.2);
        $this->Image($logo, $x, $y, $logoWidth);

        $this->SetFont('Helvetica', 'B', 12);
        $this->setXY(10, $y+$logoHeight+1);
        $this->Cell(97*2+20, 6, $this->contents->schoolName, 0, 1, 'C');

        if (isset($this->website)) {
            $this->setXY(10, $y+$logoHeight+7);
            $this->Cell(97*2+20, 6, $this->website, 0, 1, 'C');
        }

        $this->SetAlpha(1);

        $this->setXY($initialX, $initialY);
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

        // draw line only if the values are not 0
        $drawLine = false;
        for ($i=0; $i<$nrSubjects-1; $i++) {
            if ($percentagesLine[$i] != 0) {
                $drawLine = true;
                break;
            }
        }
        if (!$drawLine) {
            return;
        }

        // draw red line on graph
        $this->SetDrawColor(203, 70, 41);
        $this->SetLineWidth(1);
        for ($i=0; $i<$nrSubjects-1; $i++) {

            $x1 = $x + $colWidth * $i + $lineExtra + $cellWidth + $barOffset + $halfBarWidth;
            $x2 = $x1 + $colWidth;

            $line1Height = round($percentagesLine[$i]/100 * $graphHeight, 2);
            $line2Height = round($percentagesLine[$i+1]/100 * $graphHeight, 2);
            $y1 = $baseLine - $line1Height;
            $y2 = $baseLine - $line2Height;

            $this->Line($x1, $y1, $x2, $y2);
        }
        $this->SetLineWidth(0.1);
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

