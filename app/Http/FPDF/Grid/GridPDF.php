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

                } elseif ($column->hasDateTimeFormat()) {
                    $items[] = style_datetime($row[$column->name()]);

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
}

