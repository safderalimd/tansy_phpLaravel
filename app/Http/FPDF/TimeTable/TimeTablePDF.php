<?php

namespace App\Http\FPDF\TimeTable;
use BasePDF;

require app_path('Http/FPDF/fpdf181/base-fpdf.php');

class TimeTablePDF extends BasePDF
{
    public function generate($export)
    {
        $this->setContents(new TimeTableContents($export));
        $this->SetTitle('Time Table');

        $this->AddPage();
        $this->drawSchoolHeader();
        $this->drawGridInfo();
        $this->drawPrintDateTime();
        $this->drawTimeTable();
        $this->drawCenterWatermark();
        $this->show();
    }

    public function drawGridInfo()
    {
        $this->SetFont('Helvetica', '', 12);
        $this->Ln(4);

        $label = 'Account: '; // $this->contents->showType() == 'student' ? 'Class: ' : 'Teacher: ';
        $this->CellWidthAuto(6, $label);
        $this->SetFont('Helvetica', 'B', 12);
        $this->Cell(0, 6, $this->contents->dropdownFilter, 0, 1, 'L');
        $this->SetFont('Helvetica', '', 12);

        $this->CellWidthAuto(6, 'Start Date: ');
        $this->SetFont('Helvetica', 'B', 12);
        $this->Cell(0, 6, $this->contents->startDateFilter, 0, 1, 'L');
        $this->SetFont('Helvetica', '', 12);
    }

    public function drawTimeTable()
    {
        $this->SetDrawColor(221, 221, 221);
        $this->SetFillColor(245, 245, 245);
        $x = $this->getX();
        $y = $this->getY();
        $tableHeight = $this->GetPageHeight() - $y - 12;
        $nrRows = count($this->contents->periods) + 1;
        $nrColumnsDays = count($this->contents->weekDays);
        $nrColumns = $nrColumnsDays + 1;
        $cellHeight = round($tableHeight/$nrRows, 2, PHP_ROUND_HALF_DOWN);

        // find max width of first column
        $periodNameWidth = 10;
        $periodTimeWidth = 26.59;
        $this->SetFont('Helvetica', 'B', 12);
        foreach ($this->contents->periods as $period) {
            $periodName = isset($period['period_name']) ? $period['period_name'] : '';
            $width = $this->GetStringWidth($periodName);
            if ($width > $periodNameWidth) {
                $periodNameWidth = $width;
            }
        }
        $periodWidth = $periodNameWidth + $periodTimeWidth + 1;

        // find out the width of the rest of the cells
        $cellWidth = round(($this->GetPageWidth() - 20 - $periodWidth) / $nrColumnsDays, 2);
        $maxWidth = $periodWidth + $nrColumnsDays * $cellWidth;

        // set header row with days of the week
        $this->SetFont('Helvetica', 'B', 12);
        $this->Cell($periodWidth, $cellHeight, '', 1, 0, 'C');
        foreach ($this->contents->weekDays as $day) {
            $dayName = isset($day['week_day_short_code']) ? $day['week_day_short_code'] : '';
            $this->Cell($cellWidth, $cellHeight, $dayName, 1, 0, 'C');
        }
        $this->Ln();
        $this->SetFont('Helvetica', '', 12);

        $fill = true;
        foreach ($this->contents->periods as $period) {
            $periodName = isset($period['period_name']) ? $period['period_name'] : '';
            $startTime = isset($period['start_time']) ? $period['start_time'] : '';
            $endTime = isset($period['end_time']) ? $period['end_time'] : '';
            $periodType = isset($period['period_type']) ? $period['period_type'] : '';

            if ($periodType == 'Break') {
                $initialX = $this->getX();
                $this->Cell($maxWidth, $cellHeight, '', 1, 0, 'R', $fill);
                $this->setX($initialX);
                $this->SetFont('Helvetica', 'B', 12);
                $this->Cell($maxWidth/2, $cellHeight, $periodName, 0, 0, 'R', false);
                $this->SetFont('Helvetica', '', 12);
                $text = hour_minutes($startTime) . ' - ' . hour_minutes($endTime);
                $this->Cell($maxWidth/2, $cellHeight, $text, 0, 1, 'L', false);

            } else {
                // draw period cell
                $initialX = $this->getX();
                $this->Cell($periodWidth, $cellHeight, '', 0, 0, 'R', $fill);
                $this->setX($initialX);
                $this->SetFont('Helvetica', 'B', 12);
                $this->Cell($periodNameWidth, $cellHeight, $periodName, 0, 0, 'R', $fill);
                $this->SetFont('Helvetica', '', 12);
                $text = ' ' . hour_minutes($startTime) . ' - ' . hour_minutes($endTime);
                $this->Cell($periodTimeWidth, $cellHeight, $text, 0, 0, 'R', $fill);
                $this->setX($initialX);
                $this->Cell($periodWidth, $cellHeight, '', 1, 0, 'R', false);

                foreach ($this->contents->weekDays as $day) {
                    $weekDay = isset($day['week_day']) ? $day['week_day'] : '';
                    $subject = $this->contents->export->findSubject($this->contents->rows, $periodName, $weekDay);
                    $shortCode = isset($subject['subject_short_code']) ? $subject['subject_short_code'] : '';
                    $className = isset($subject['class_name']) ? $subject['class_name'] : '';
                    // $cellText = ($this->contents->showType() == 'student') ? $shortCode : $className;
                    $cellText = $shortCode;
                    $this->Cell($cellWidth, $cellHeight, $cellText, 1, 0, 'C', $fill);

                }
                $this->Ln();
            }
            $fill = !$fill;
        }
    }
}

