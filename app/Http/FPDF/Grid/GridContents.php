<?php

namespace App\Http\FPDF\Grid;

class GridContents
{
    public $grid;

    public $schoolName;

    public $phoneNr;

    public $reportName;

    public function __construct($grid)
    {
        $this->grid = $grid;

        $this->schoolName = $grid->organizationName();
        $this->phoneNr = phone_number_spaces($grid->organizationPhone());
        $this->reportName = $grid->screenName;
    }

    public function getFilterValue($filter)
    {
        $filterName = 'f' . $filter->id();
        $filterValue = isset($this->grid->{$filterName}) ? $this->grid->{$filterName} : '';

        if ($filter->isDateInput()) {
            return style_date($filterValue);

        } elseif ($filter->isDropDown()) {
            foreach($this->grid->filterDropdownValues($filter) as $option) {
                if (!isset($option['drop_down_filter_id']) || !isset($option['drop_down_list_name'])) {
                    continue;
                }

                if ($filterValue == $option['drop_down_filter_id']) {
                    return $option['drop_down_list_name'];
                }
            }
            return '-';
        }
    }
}
