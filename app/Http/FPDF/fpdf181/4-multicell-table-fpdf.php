<?php

require('3-alpha-fpdf.php');

class MulticellTablePDF extends AlphaPDF
{
    private $widths;

    private $aligns;

    private $rowMultiCellHeight = 5;

    protected $_rowMultiCellFill = 0;

    protected $_drawingDynamicTable = false;

    protected $_dynamicTableOptions;

    protected $_dynamicTableHeaderRow;

    protected $_currencyColumns;

    protected $_isDrawingDynamicTableHeader = false;

    public function setRowMultiCellHeight($height)
    {
        $this->rowMultiCellHeight = $height;
    }

    public function setRowMultiCellFill($fill)
    {
        $this->_rowMultiCellFill = (int)$fill;
    }

    public function getRowMultiCellFill()
    {
        return (boolean) $this->_rowMultiCellFill;
    }

    public function inverseRowMultiCellFill()
    {
        $fill = $this->getRowMultiCellFill();
        $this->setRowMultiCellFill(! $fill);
    }

    public function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths=$w;
    }

    public function resetCurrencyColumns()
    {
        $this->_currencyColumns = null;
    }

    public function setCurrencyColumns($columns)
    {
        $this->_currencyColumns = $columns;
    }

    public function showCurrencyAmount($i)
    {
        if ($this->_isDrawingDynamicTableHeader == true) {
            return false;
        }

        if (! isset($this->_currencyColumns[$i])) {
            return false;
        }

        if ($this->_currencyColumns[$i] == true) {
            return true;
        }

        return false;
    }

    public function setDefaultWidths($data)
    {
        $this->widths = [];
        $width = round(($this->GetPageWidth()-20)/count($data), 2);
        for($i=0;$i<count($data);$i++) {
            $this->widths[] = $width;
        }
    }

    public function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }

    public function Row($data, $drawBorder = true)
    {
        if (empty($this->widths)) {
            $this->setDefaultWidths($data);
        }

        //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=$this->rowMultiCellHeight*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        $initialX = $this->getX();
        $initialY = $this->getY();

        // draw the row backgroud
        $sumOfWidhts = 0;
        for($i=0;$i<count($this->widths);$i++) {
            $sumOfWidhts += $this->widths[$i];
        }
        if ($this->getRowMultiCellFill()) {
            $this->Rect($initialX,$initialY,$sumOfWidhts,$h, 'F');
        }

        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Print the text
            if ($this->showCurrencyAmount($i)) {
                $this->MultiCellAmount($w,$this->rowMultiCellHeight,$data[$i],0,$a);
            } else {
                $this->MultiCell($w,$this->rowMultiCellHeight,$data[$i],0,$a);
            }
            if ($drawBorder) {
                //Draw the border
                $this->Rect($x,$y,$w,$h);
            }
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    public function CheckPageBreak($h)
    {
        $pageBreakTrigger = $this->PageBreakTrigger;
        if ($this->_drawingDynamicTable && $this->_showPagination) {
            $pageBreakTrigger = $this->GetPageHeight() - 15;
        }

        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$pageBreakTrigger) {
            $this->drawCenterWatermark();
            $this->AddPage($this->CurOrientation);

            // draw the header for a new page
            if ($this->_drawingDynamicTable) {
                $this->setRowMultiCellFill(false);
                $this->drawDynamicTableHeader();
                $this->setRowMultiCellFill(true);
            }
        }
    }

    public function NbLines($w,$txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb)
        {
            $c=$s[$i];
            if($c=="\n")
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

    public function drawDynamicTable($headerRow, $tableRows, $options = [])
    {
        $this->_drawingDynamicTable = true;
        $this->_dynamicTableOptions = $options = array_merge($this->getDefaultOptions(), $options);
        $this->_dynamicTableHeaderRow = $headerRow;

        // calculate the width averages
        $averages = [];
        $counts = [];
        $minimumWidth = [];

        // set the widths of the header cells
        foreach ($headerRow as $column) {
            $counts[] = 1;
            if (!$this->isEmpty($column)) {
                $averages[] = $this->GetStringWidth($column);
                $minimumWidth[] = 3 + $this->longestWordWidth($column);
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
        $this->setRowMultiCellHeight($options['multicellHeight']);

        // draw first row
        $this->drawDynamicTableHeader();

        foreach ($tableRows as $row) {
            $this->inverseRowMultiCellFill();
            $this->Row($row);
        }
        $this->setRowMultiCellFill(false);
        $this->_drawingDynamicTable = false;
    }

    public function drawDynamicTableHeader()
    {
        $options = $this->_dynamicTableOptions;

        $this->_isDrawingDynamicTableHeader = true;
        $this->font($options['rowFontSize']); $this->fontType($options['headerFontType']);
        $this->Row($this->_dynamicTableHeaderRow);
        $this->fontType($options['rowFontType']);
        $this->_isDrawingDynamicTableHeader = false;
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

    public function getDefaultOptions()
    {
        return [
            'multicellHeight' => 10,
            'headerFontType' => 'B',
            'rowFontSize' => 12,
            'rowFontType' => '',
        ];
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
