<?php

require('3-alpha-fpdf.php');

class MulticellTablePDF extends AlphaPDF
{
    private $widths;

    private $aligns;

    private $rowMultiCellHeight = 5;

    protected $rowMultiCellFill = 0;

    public function setRowMultiCellHeight($height)
    {
        $this->rowMultiCellHeight = $height;
    }

    public function setRowMultiCellFill($fill)
    {
        $this->rowMultiCellFill = (int)$fill;
    }

    public function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths=$w;
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

    public function Row($data)
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
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Print the text
            $this->MultiCell($w,$this->rowMultiCellHeight,$data[$i],0,$a, $this->rowMultiCellFill);
            //Draw the border
            $this->Rect($x,$y,$w,$h);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    public function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger) {
            $this->drawCenterWatermark();
            $this->AddPage($this->CurOrientation);
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
}
