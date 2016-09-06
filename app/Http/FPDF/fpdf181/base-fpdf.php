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
}
