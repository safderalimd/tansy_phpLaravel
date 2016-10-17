<?php

namespace App\Http\FPDF\MarkSheet;
use BasePDF;

require app_path('Http/FPDF/fpdf181/base-fpdf.php');

class MarkSheetPDF extends BasePDF
{
    protected $drawLogoWatermark = true;

    protected $contents;

    public function generate($export)
    {
        $export->setOwnerOrganizationInfo();
        $this->setContents(new MarkSheetContents($export));
        $this->SetTitle($this->contents->title);
        $this->SetAuthor('Tansycloud');

        $this->AddPage();
        $this->drawHeaderV1();
        $this->drawMarkSheetInfo();
        $this->drawMarkSheetTable();
        $this->drawCenterWatermark();
        $this->show();
    }

    public function drawMarkSheetInfo()
    {
        $this->SetFont('Helvetica', '', 12);
        $this->Ln(4);

        $this->Cell(0, 6, 'Exam Name: ' . $this->contents->examName, 0, 1, 'L');

        $this->CellWidthAuto(6, 'Class: ' . $this->contents->className);
        $this->Cell(0, 6, 'Subject: ' . $this->contents->subjectName, 0, 1, 'R');
    }

    public function drawMarkSheetTable()
    {
        $this->SetFont('Helvetica', '', 10);
        $widths = [30, 60];
        $n = count($this->contents->columns) == 0 ? 1 : count($this->contents->columns);
        $w = ($this->GetPageWidth() - 20 - 90)/$n;

        // build header row
        $headerRow = ['Roll Number', 'Student Name']; 
        $secondRow = ['', ''];
        foreach ($this->contents->columns as $column) {
            $headerRow[] = isset($column['sub_exam_name']) ? $column['sub_exam_name'] : '';
            $secondRow[] = isset($column['max_marks']) ? ' Max. '.$column['max_marks'] : '';
            $widths[] = $w;
        }
        
        // build rows
        $tableRows = [];
        foreach($this->contents->allItems as $item) {
            $row = [];
            $row[] = $item['student_roll_number'];
            $row[] = $item['student_full_name'];
            foreach ($this->contents->columns as $column) {
                $row[] = '';
            }
            $tableRows[] = $row;
        }

        // draw header row
        $this->font(10); $this->fontType('B');
        $this->setWidths($widths);
        $this->setRowMultiCellHeight(6);
        $initialX = $this->getX();
        $initialY = $this->getY();
        $this->Row($headerRow, false);
        $this->fontType('');
        $this->Row($secondRow, false);
        $h = $this->getY() - $initialY;
        $xpos = 10;
        for ($i = 0; $i<count($widths)-1; $i++) {
            $xpos += $widths[$i]; 
            $this->Line($xpos, $initialY, $xpos, $this->getY());
        }
        $this->Rect($initialX, $initialY, 190, $h);

        // draw rows
        $this->setRowMultiCellHeight(7);
        $fill = true;
        foreach ($tableRows as $row) {
            $this->setRowMultiCellFill($fill);
            $this->Row($row);
            $fill = !$fill;
        }
        $this->setRowMultiCellFill(false);
    }
}

