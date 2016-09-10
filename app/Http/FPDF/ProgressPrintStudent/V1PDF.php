<?php

namespace App\Http\FPDF\ProgressPrintStudent;
use BasePDF;

require app_path('Http/FPDF/fpdf181/base-fpdf.php');

class V1PDF extends BasePDF
{
    public function generate($export, $progress)
    {
        $this->setContents(new V1Contents($export, $progress));
        $this->SetTitle('Student Report');
        $this->SetAuthor('Tansycloud');

        foreach ($this->contents->students as $student) {
            $this->contents->setStudent($student);

            $this->AddPage();
            $this->drawSchoolHeader();
            $this->drawStudentInfo();
            $this->drawGradesTable();
            $this->drawGradesTotals();
            $this->drawSignatures();
            $this->drawCenterWatermark();
        }

        $this->show();
    }

    public function drawStudentInfo()
    {
        $this->SetFont('Helvetica', '', 12);
        $this->Ln(4);

        $this->CellWidthAuto(6, 'Student Name: ');
        $this->SetFont('Helvetica', 'B', 12);
        $this->Cell(0, 6, $this->contents->studentName, 0, 1, 'L');
        $this->SetFont('Helvetica', '', 12);

        $this->CellWidthAuto(6, 'Class: ');
        $this->SetFont('Helvetica', 'B', 12);
        $this->Cell(0, 6, $this->contents->className, 0, 1, 'L');
        $this->SetFont('Helvetica', '', 12);

        $this->CellWidthAuto(6, 'Roll No. ');
        $this->SetFont('Helvetica', 'B', 12);
        $this->Cell(0, 6, $this->contents->rollNr, 0, 1, 'L');
        $this->SetFont('Helvetica', '', 12);
    }

    public function drawGradesTable()
    {
        $headerRow = ['Subjects', 'Max Marks', 'Obtain Marks', 'GPA'];
        $subjects = [];
        foreach ($this->contents->getStudent() as $subject) {
            $row = [];
            $row[] = isset($subject['subject_name']) ? $subject['subject_name'] : '';
            $row[] = isset($subject['subject_max_total']) ? $subject['subject_max_total'] : '';
            $row[] = isset($subject['student_subject_max_total']) ? $subject['student_subject_max_total'] : '';
            $row[] = isset($subject['subject_gpa']) ? $subject['subject_gpa'] : '';
            $subjects[] = $row;
        }

        $this->Ln(3);
        $this->SetDrawColor(221, 221, 221);
        $this->SetFillColor(245, 245, 245);

        $this->setRowMultiCellHeight(10);
        if (count($subjects) > 15) {
            $this->setRowMultiCellHeight(7);
        }
        $this->SetFont('Helvetica', 'B', 12);
        $this->Row($headerRow);

        $this->SetFont('Helvetica', '', 12);
        $fill = true;
        foreach ($subjects as $row) {
            $this->setRowMultiCellFill($fill);
            $this->Row($row);
            $fill = !$fill;
        }
    }

    public function drawGradesTotals()
    {
        $this->Ln(4);
        $x = $this->GetPageWidth()/2;

        $this->SetFont('Helvetica', '', 12);

        // first row
        $this->CellWidthAuto(6, 'Max Total: ');
        $this->SetFont('Helvetica', 'B', 12);
        $this->Cell(30, 6, $this->contents->maxTotalMarks, 0, 0, 'L');
        $this->SetFont('Helvetica', '', 12);

        $this->setX($x);
        $this->CellWidthAuto(6, 'Student Total: ');
        $this->SetFont('Helvetica', 'B', 12);
        $this->Cell(30, 6, $this->contents->grandTotal, 0, 1, 'L');
        $this->SetFont('Helvetica', '', 12);

        // second row
        $this->CellWidthAuto(6, 'Percentage: ');
        $this->SetFont('Helvetica', 'B', 12);
        $this->Cell(30, 6, $this->contents->percentage, 0, 0, 'L');
        $this->SetFont('Helvetica', '', 12);

        $this->setX($x);
        $this->CellWidthAuto(6, 'Grade: ');
        $this->SetFont('Helvetica', 'B', 12);
        $this->Cell(30, 6, $this->contents->grade, 0, 1, 'L');
        $this->SetFont('Helvetica', '', 12);

        // third row
        $this->CellWidthAuto(6, 'GPA: ');
        $this->SetFont('Helvetica', 'B', 12);
        $this->Cell(30, 6, $this->contents->gpa, 0, 1, 'L');
        $this->SetFont('Helvetica', '', 12);
    }

    public function drawSignatures()
    {
        $this->Ln(4);
        $width = round(($this->GetPageWidth()-20)/3, 2);

        $this->SetFont('Helvetica', 'B', 12);
        $this->setX(10);
        $this->Cell($width, 10, 'Principal Signature', 0, 0, 'C');
        $this->setX(10+$width);
        $this->Cell($width, 10, 'Teacher Signature', 0, 0, 'C');
        $this->setX(10+$width*2);
        $this->Cell($width, 10, 'Parent Signature', 0, 0, 'C');
    }
}

