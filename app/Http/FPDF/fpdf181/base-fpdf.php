<?php

require('4-multicell-table-fpdf.php');

class BasePDF extends MulticellTablePDF
{
	protected $contents;

	protected $currentFontName = 'Helvetica';

	protected $currentFontType = '';

	protected $currentFontSize = 12;

	protected $_showPagination = false;

	/**
	 * The margin on the left and the right.
	 *
	 * @var integer
	 */
	protected $_xMargin = 10;

	public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
	{
		parent::__construct($orientation, $unit, $size);
		$this->SetAutoPageBreak(true, 10);
		$this->SetAuthor('Tansycloud');
		$this->SetDrawColor(221, 221, 221);
		$this->SetFillColor(245, 245, 245);
		$this->updateFontSettings();
	}

	public function font($size)
	{
		$this->currentFontSize = $size;
		$this->updateFontSettings();
	}

	public function fontType($type)
	{
		$this->currentFontType = $type;
		$this->updateFontSettings();
	}

	public function updateFontSettings()
	{
		$this->SetFont($this->currentFontName, $this->currentFontType, $this->currentFontSize);
	}

	public function AcceptPageBreak()
	{
		parent::AcceptPageBreak();
		$this->drawCenterWatermark();
	}

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

	    $middle = round($this->GetPageWidth()/2, 2);
	    $this->setXY($middle - 30, 15);
	    $this->MultiCell(60, 7, $this->contents->schoolName, 0, 'C');

	    $this->SetFontSize(12);
	    $this->Cell(0, 6, 'Phone No. ' . $this->contents->phoneNr, 0, 1, 'C');

	    // draw schoo logo
	    $logo = logo_path();
	    $logoWidth = 40;
	    $this->Image($logo, $middle - 75, 10, $logoWidth);

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

	public function drawCenterWatermark()
	{
		$fontName = $this->currentFontName;
		$fontType = $this->currentFontType;
		$fontSize = $this->currentFontSize;

	    $this->SetFont('Helvetica', 'B', 12);

	    $x = round($this->GetPageWidth()/2, 2);
	    $y = round($this->GetPageHeight()/2, 2);

	    $text = $this->contents->schoolName;
	    $stringWidth = $this->GetStringWidth($text);
	    $baseWdith = round(0.52 * $stringWidth, 2);
	    $x = $x - ($baseWdith/2);

	    $triangleHeight = round(0.85 * $stringWidth, 2);
	    $y = $y + ($triangleHeight/2);

	    $this->SetAlpha(0.2);
	    $this->RotatedText($x, $y, $text, 45);
	    $this->SetAlpha(1);

	    $this->currentFontName = $fontName;
	    $this->currentFontType = $fontType;
	    $this->currentFontSize = $fontSize;
	    $this->updateFontSettings();
	}

	public function drawPrintDateTime()
	{
		$this->SetFont('Helvetica', '', 12);
		$this->CellWidthAuto(6, 'Print Date: ' . current_date());
		$this->Cell(0, 6, 'Print Time: ' . current_time(), 0, 1, 'R');
	}

	public function showPagination()
	{
		$this->_showPagination = true;
		$this->AliasNbPages();
	}

	public function Footer()
	{
	    // Position at 1.5 cm from bottom
	    $this->SetY(-15);

	    // Helvetica italic 8
	    $this->SetFont('Helvetica','I', 8);

	    // Page number
	    $this->Cell(0, 10, 'Page: '.$this->PageNo().'/{nb}', 0, 0, 'R');
	}
}
