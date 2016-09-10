<?php

require('4-multicell-table-fpdf.php');

class BasePDF extends MulticellTablePDF
{
	protected $contents;

	public function setContents($contents)
	{
	    $this->contents = $contents;
	}

	public static function portrait()
	{
	    // A4 = 210 × 297 millimeters
	    return new static('P', 'mm', 'A4');
	}

	public static function landscape()
	{
	    // A4 = 297 x 210 millimeters
	    return new static('L', 'mm', 'A4');
	}

	public function Show()
	{
		$this->Output();
		die();
	}

	public function CellWidthAuto($height, $text, $border = 0, $nextLine = 0, $align = 'L')
	{
		$width = $this->GetStringWidth($text);
		$this->Cell($width, $height, $text, $border, $nextLine, $align);
	}

	public function drawSchoolHeader()
	{
	    $this->SetFont('Helvetica', '', 16);
	    $this->SetTextColor(51, 51, 51);

	    $this->setXY(75, 15);
	    $this->MultiCell(60, 7, $this->contents->schoolName, 0, 'C');

	    $this->SetFontSize(12);
	    $this->Cell(0, 6, 'Phone No. ' . $this->contents->phoneNr, 0, 1, 'C');

	    // draw schoo logo
	    $logo = logo_path();
	    $logoWidth = 40;
	    $this->Image($logo, 35, 10, $logoWidth);

	    // get the height of the resized logo
	    $size = GetImageSize($logo);
	    $width = isset($size[0]) ? $size[0] : 0;
	    $height = isset($size[1]) ? $size[1] : 0;
	    $ratio = $width / $height;
	    $logoHeight = $logoWidth / $ratio;

	    $this->setY(14 + $logoHeight);
	    $this->SetFont('Helvetica', 'B', 15);
	    $this->Cell(0, 6, $this->contents->reportName, 0, 1, 'C');
	}
}
