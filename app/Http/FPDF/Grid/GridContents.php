<?php

namespace App\Http\FPDF\Grid;

class GridContents
{
    public $grid;

    public $schoolName;

    public $headerSecondLine = '';

    public $headerThirdLine = '';

    public $reportName;

    public $website;

    public function __construct($grid)
    {
        $this->grid = $grid;

        $this->schoolName = $grid->organizationName();
        $this->headerSecondLine = $export->organizationLine2();
        $this->headerThirdLine = $export->organizationLine3();
        $this->website = $export->organizationWebsite();
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

        return false;
    }
}
