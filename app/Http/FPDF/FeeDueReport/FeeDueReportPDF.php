<?php

namespace App\Http\FPDF\FeeDueReport;
use BasePDF;

require app_path('Http/FPDF/fpdf181/base-fpdf.php');

class FeeDueReportPDF extends BasePDF
{
    public function generate($export)
    {
        $this->setContents(new FeeDueReportContents($export));
        $this->SetTitle($this->contents->reportName);
        $this->showPagination();

        $this->AddPage();
        $this->drawSchoolHeader();
        $this->drawTableInfo();
        $this->drawPrintDateTime();
        $this->drawFeeDueTable();
        $this->drawCenterWatermark();
        $this->show();
    }

    public function drawTableInfo()
    {
        $this->fontType('');
        $this->Cell(0, 6, 'Filter: ' . $this->contents->filterCriteria, 0, 1, 'L');
    }

    public function drawFeeDueTable()
    {
        // build header row
        $headerRow = ['Class', 'Student Name', 'Parent Name', 'Mobile Phone', 'Due Amount'];

        // build rows
        $tableRows = [];
        foreach($this->contents->export->pdfData as $row) {
            $items = [];

            $items[] = isset($row['class_name']) ? $row['class_name'] : '';
            $items[] = isset($row['student_full_name']) ? $row['student_full_name'] : '';
            $items[] = isset($row['parent_full_name']) ? $row['parent_full_name'] : '';
            $items[] = isset($row['mobile_phone']) ? phone_number($row['mobile_phone']) : '';
            $items[] = isset($row['due_amount']) ? amount($row['due_amount']) : '';

            $tableRows[] = $items;
        }

        $options = [
            'rowFontSize' => 11,
            'multicellHeight' => 9,
        ];

        $this->drawDynamicTable($headerRow, $tableRows, $options);
    }
}

