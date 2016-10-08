<?php

namespace App\Http\FPDF\OneStudent;
use BasePDF;

require app_path('Http/FPDF/fpdf181/base-fpdf.php');

class OneStudentPDF extends BasePDF
{
    protected $_cellWidth;
    protected $_leftMargin = 35;
    protected $drawLogoWatermark = true;

    public function generate($export)
    {
        $this->setContents(new OneStudentContents($export));
        $this->SetTitle($this->contents->reportName);

        $this->AddPage();
        $this->drawHeaderV1();
        $this->drawStudentDetails();
        $this->drawCenterWatermark();
        $this->show();
    }

    public function drawStudentDetails()
    {
        $this->setStudentCellWidth();

        $this->drawSectionHeader('Student Details');
        $this->drawHeaderRow('First Name:', 'Last Name:');
        $this->drawDetailsRow($this->contents->firstName, $this->contents->lastName);
        $this->drawHeaderRow('Date of Birth:', 'Gender:');
        $this->drawDetailsRow($this->contents->dateOfBirth, $this->contents->gender);

        $this->drawSectionHeader('Contact Details');
        $this->drawHeaderRow('Mobile Phone:', 'Home Phone:');
        $this->drawDetailsRow($this->contents->mobilePhone, $this->contents->homePhone);

        $this->drawHeaderRow('Email:');
        $this->drawDetailsRow($this->contents->email);

        $this->drawHeaderRow('Home Address');
        $this->drawAddressRow($this->contents->address1);
        $this->drawAddressRow($this->contents->address2);
        $this->drawAddressRow($this->contents->cityName);

        $this->drawSectionHeader('Student Info');
        $this->drawHeaderRow('Admission Number:', 'Admission Date:');
        $this->drawDetailsRow($this->contents->admissionNumber, $this->contents->admissionDate);
        $this->drawHeaderRow('Admitted To:', 'Current Class:');
        $this->drawDetailsRow($this->contents->admittedToClassGroup, $this->contents->className);
        $this->drawHeaderRow('Roll Number:', 'Identification:');

        $identification = $this->contents->identification1;
        if (empty($identification)) {
            $identification = $this->contents->identification2;
        } else {
            $identification .= ' ' . $this->contents->identification2;
        }

        $this->drawDetailsRow($this->contents->studentRollNumber, $identification);
        $this->drawHeaderRow('Caste Name:', 'Religion Name:');
        $this->drawDetailsRow($this->contents->casteName, $this->contents->religionName);
        $this->drawHeaderRow('Communication Language:');
        $this->drawDetailsRow($this->contents->motherTounge);

        $this->drawSectionHeader('Contact Details');
        $this->drawHeaderRow('Parent Name:', 'Designation:');
        $this->drawDetailsRow($this->contents->parentFullName, $this->contents->parentDesignationName);
    }

    public function setStudentCellWidth()
    {
        $this->_cellWidth = round(($this->GetPageWidth() - 2*$this->_leftMargin)/2 , 2);
    }

    public function drawSectionHeader($text)
    {
        $this->Ln(3);
        $this->SetFont('Helvetica', '', 14);
        $this->Cell(0, 6, $text, 0, 1, 'L');
    }

    public function drawHeaderRow($text1, $text2 = null)
    {
        $this->Ln(2);
        $this->setX($this->_leftMargin);
        $this->SetFont('Courier', 'B', 11);
        $this->Cell($this->_cellWidth, 6, $text1, 0, 0, 'L');

        if (!is_null($text2)) {
            $this->Cell($this->_cellWidth, 6, $text2, 0, 0, 'L');
        }

        $this->Ln();
    }

    public function drawDetailsRow($text1, $text2 = null)
    {
        $this->setX($this->_leftMargin);
        $originalY = $this->getY();

        $this->SetFont('Courier', '', 11);
        $this->MultiCell($this->_cellWidth, 6, $text1, 0, 'L');
        $y1 = $y2 = $this->getY();

        if (!is_null($text2)) {
            $this->setXY($this->_leftMargin + $this->_cellWidth, $originalY);
            $this->MultiCell($this->_cellWidth, 6, $text2, 0, 'L');
            $y2 = $this->getY();
        }

        $this->setXY($this->_leftMargin, max($y1, $y2));
    }

    public function drawAddressRow($text)
    {
        $this->SetFont('Courier', '', 12);
        if (!empty($text)) {
            $this->setX($this->_leftMargin);
            $this->MultiCell(0, 6, $text, 0, 'L');
        }
    }
}

