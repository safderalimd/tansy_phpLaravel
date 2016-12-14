<?php

namespace App\Http\FPDF\ProgressPrintClass;
use BasePDF;

require app_path('Http/FPDF/fpdf181/base-fpdf.php');

class ProgressPrintClassPDF extends BasePDF
{
    protected $drawLogoWatermark = true;

    public function generate($export, $progress)
    {
        $this->setContents(new ProgressPrintClassContents($export, $progress));
        $this->SetTitle($this->contents->reportName);
        $this->showPagination();

        $this->AddPage();
        $this->drawHeaderV1();
        $this->drawTableInfo();
        $this->drawPrintDateTime();
        $this->drawClassTable();
        $this->drawCenterWatermark();
        $this->show();
    }

    public function drawTableInfo()
    {
        $this->fontType('');
        $this->CellWidthAuto(6, 'Class Name: ' . $this->contents->className);
        $this->Cell(0, 6, 'Max Marks: ' . $this->contents->maxTotalMarks, 0, 1, 'R');
    }

    public function drawClassTable()
    {
        $this->font(12); $this->fontType('');

        // build header row
        $headerRow = ['Student Name', 'Student #'];
        foreach ($this->contents->allSubjects as $subject) {
            $headerRow[] = $subject;
        }
        $headerRow[] = 'Total';
        $headerRow[] = 'Grade';
        $headerRow[] = 'Percentage';
        $headerRow[] = 'GPA';
        $headerRow[] = 'Result';

        // build rows
        $tableRows = [];
        foreach($this->contents->progress->students as $student) {
            $this->contents->setStudent($student);
            $items = [];
            $items[] = $this->contents->studentName;
            $items[] = $this->contents->rollNr;

            foreach ($this->contents->allSubjects as $oneSubject) {
                $subject = $student->where('subject_name', $oneSubject)->first();
                $items[] = isset($subject['student_subject_max_total']) ? number_format($subject['student_subject_max_total'], 2) : '-';
            }

            $items[] = number_format($this->contents->grandTotal, 2);
            $items[] = $this->contents->grade;
            $items[] = $this->contents->percentage;
            $items[] = $this->contents->gpa;
            $items[] = $this->contents->passFail;

            $tableRows[] = $items;
        }

        $options = [
            'rowFontSize' => 9,
            'multicellHeight' => 6,
        ];
        $this->drawDynamicTable($headerRow, $tableRows, $options);
    }
}

