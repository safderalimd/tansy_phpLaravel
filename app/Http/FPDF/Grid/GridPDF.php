<?php

namespace App\Http\FPDF\Grid;
use BasePDF;

require app_path('Http/FPDF/fpdf181/base-fpdf.php');

class GridPDF extends BasePDF
{
    public function generate($grid)
    {
        $this->setContents(new GridContents($grid));
        $this->SetTitle($this->contents->reportName);

        $this->AddPage();
        $this->drawSchoolHeader();
        $this->drawGridFilters();
        $this->drawPrintDateTime();
        $this->drawGridTable();
        $this->drawCenterWatermark();
        $this->show();
    }

    public function drawGridFilters()
    {
        $this->font(12); $this->fontType('');
        $this->Ln(4);

        foreach ($this->contents->grid->filters as $filter) {
            $filterLabel = $filter->label();
            $filterValue = $this->contents->getFilterValue($filter);

            $this->CellWidthAuto(6, $filterLabel . ': ');
            $this->fontType('B');
            $this->Cell(0, 6, $filterValue, 0, 1, 'L');
            $this->fontType('');
        }
    }

    public function drawGridTable()
    {
        $this->font(12); $this->fontType('');
        $grid = $this->contents->grid;
        $columns = $grid->columns();
        $rowIndex = 1;

        // build header row
        $headerRow = [];
        if ($grid->settings->showPdfRowNumbers()) {
            $headerRow[] = '#';
        }
        foreach ($columns as $column) {
            $headerRow[] = $column->label();
        }

        // build rows
        $tableRows = [];
        foreach($grid->rows() as $row) {
            $items = [];
            if ($grid->settings->showPdfRowNumbers()) {
                $items[] = $rowIndex++;
            }
            foreach($columns as $column) {
                if (!isset($row[$column->name()])) {
                    $items[] = '';
                    continue;
                }

                if ($column->hasMobileFormat()) {
                    $items[] = phone_number($row[$column->name()]);

                } elseif ($column->hasDateFormat()) {
                    $items[] = style_date($row[$column->name()]);

                } elseif ($column->hasCurrencyFormat()) {
                    $items[] = amount($row[$column->name()]);
                    // &#x20b9;

                } elseif ($column->hasNumberFormat()) {
                    $items[] = nr($row[$column->name()]);

                } else {
                    $items[] = $row[$column->name()];
                }
            }
            $tableRows[] = $items;
        }

        $this->drawDynamicTable($headerRow, $tableRows);
    }

    public function drawDynamicTable($headerRow, $tableRows)
    {
        for ($i=0; $i < 15 ; $i++) {
            $tableRows[] = $tableRows[0];
        }

        // calculate the width averages
        $averages = [];
        $counts = [];
        $minimumWidth = [];

        // set the widths of the header cells
        foreach ($headerRow as $column) {
            $counts[] = 1;
            if (!$this->isEmpty($column)) {
                $averages[] = $this->GetStringWidth($column);
                $minimumWidth[] = $this->longestWordWidth($column);
            } else {
                $averages[] = 0;
                $minimumWidth[] = 5;
            }
        }

        // sum each column, where the column is not emtpy
        foreach ($tableRows as $row) {
            $i=0;
            foreach ($row as $column) {
                if (!$this->isEmpty($column)) {
                    $averages[$i] += $this->GetStringWidth($column);
                    $counts[$i]++;
                }
                $i++;
            }
        }

        // calculate the average width of each column
        $sumOfAverages = 0;
        $sumOfMinimumWidth = 0;
        for ($i=0;$i<count($averages);$i++) {
            $averages[$i] = $averages[$i]/$counts[$i];
            $sumOfAverages += $averages[$i];
            $sumOfMinimumWidth += $minimumWidth[$i];
        }

        // calculate widths
        $widths = [];
        $tableWidth = $this->GetPageWidth() - 20;
        for ($i=0;$i<count($averages);$i++) {
            $percentage = $averages[$i] / $sumOfAverages;

            if ($sumOfMinimumWidth > $tableWidth) {
                // percentage width of total width
                $widths[] = round($percentage * $tableWidth, 2, PHP_ROUND_HALF_DOWN);
            } else {
                $remainingWidth = $tableWidth - $sumOfMinimumWidth;
                $widths[] = round($minimumWidth[$i] + $percentage * $remainingWidth, 2, PHP_ROUND_HALF_DOWN);
            }
        }

        $this->setWidths($widths);
        $this->setRowMultiCellHeight(10);

        // draw first row
        $this->font(12); $this->fontType('B');
        $this->Row($headerRow);
        $this->fontType('');

        // draw the rest of the rows
        $fill = true;
        foreach ($tableRows as $row) {
            $this->setRowMultiCellFill($fill);
            $this->Row($row);
            $fill = !$fill;
        }
        $this->setRowMultiCellFill(false);
    }

    public function isEmpty($cell)
    {
        if (is_null($cell)) {
            return true;
        }

        if (is_string($cell) && strlen($cell) == 0) {
            return true;
        }

        return false;
    }

    public function longestWordWidth($cell)
    {
        $cell = (string)$cell;
        $words = explode(' ', $cell);
        $largestWidth = 5;
        foreach ($words as $word) {
            $w = $this->GetStringWidth($word);
            if ($w > $largestWidth) {
                $largestWidth = $w;
            }
        }
        return $largestWidth;
    }
}

