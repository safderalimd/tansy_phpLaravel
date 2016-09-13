<?php

namespace App\Http\FPDF\Grid;

class GridContents
{
    public $grid;

    public $schoolName;

    public $phoneNr;

    public $reportName = 'Time Table';

    public function __construct($grid)
    {
        $this->grid = $grid;

        $this->schoolName = $grid->organizationName();
        $this->phoneNr = phone_number_spaces($grid->organizationPhone());


    }
}
