<?php

namespace App\Http\FPDF\DICE;
use BasePDF;

require app_path('Http/FPDF/fpdf181/base-fpdf.php');

class DICEPDF extends BasePDF
{
    protected $drawLogoWatermark = true;

    public function generate($export)
    {
        $this->setContents(new DICEContents($export));
        $this->SetTitle($this->contents->reportName);

        $this->AddPage();
        $this->drawHeaderV1();
        $this->drawDICE();
        $this->drawCenterWatermark();
        $this->show();
    }

    public function drawDICE()
    {
        $this->Ln(4);
        $this->SetFont('Helvetica', '', 10);
        $firstRow = $this->contents->dice->first();
        $headerRow = $firstRow->groupBy('measure_type');
        $nrColumns = count($firstRow);
        $classWidth = 35;

        // calculate widths
        $totalWidth = 0;
        $widths = [];
        foreach ($headerRow as $cell => $subTypes) {
            foreach ($subTypes as $subType) {
                $w = $this->GetStringWidth($subType['measure_sub_type']);
                $totalWidth += $w;
                $widths[] = $w;
            }
        }

        // add remaining space equally to all columns
        $remainingSpace = $this->GetPageWidth() - 20 - $totalWidth - $classWidth;
        $extraSpace = round($remainingSpace/$nrColumns, 2);
        foreach ($widths as $key => $w) {
            $widths[$key] += $extraSpace;
        }

        $initialY = $this->getY(); 
        $this->Cell($classWidth, 12, 'Class', 1, 0, 'C');
        $i = 0;
        foreach ($headerRow as $cell => $subTypes) {
            $w = 0;
            foreach ($subTypes as $subType) {
                $w += $widths[$i++];
            }
            $this->Cell($w, 6, $cell, 1, 0, 'C');
        }

        $this->setXY(10+$classWidth, $initialY+6);
        $i = 0;
        foreach ($headerRow as $cell => $subTypes) {
            foreach ($subTypes as $subType) {
                $this->Cell($widths[$i++], 6, $subType['measure_sub_type'], 1, 0, 'C');
            }
        }
        $this->Ln();

        // draw the rest of the table
        array_unshift($widths, $classWidth);
        $this->SetWidths($widths);
        $fill = false;
        foreach ($this->contents->dice as $dice) {
            $row = $dice->groupBy('measure_type');
            $fill = !$fill;
            $rowData = [];
            
            $className = $row->first()->first()['class_name'];
            $rowData[] = $className;
        
            foreach ($row as $cell => $subTypes) {
                foreach ($subTypes as $subType) {
                    $rowData[] = $subType['student_count'];
                }
            }

            $this->setRowMultiCellFill($fill);
            $this->setRowMultiCellHeight(6);
            $this->Row($rowData);
        }
    }
}

