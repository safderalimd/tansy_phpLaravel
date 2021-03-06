<?php

namespace App\Http\Grid;

class Filter
{
    protected $filter;

    protected $filterId;

    public function __construct($filter, $filterId)
    {
        $this->filter = $filter;
        $this->filterId = $filterId;
    }

    public static function make($items)
    {
        $id = 1;
        $filters = [];
        foreach ($items as $item) {
            $filters[] = new static($item, $id++);
        }

        usort($filters, function($a, $b) {
            return $a->position() > $b->position();
        });

        return $filters;
    }

    public function id()
    {
        return $this->filterId;
    }

    public function label()
    {
        return isset($this->filter['ui_label']) ? $this->filter['ui_label'] : 'N/A';
    }

    public function position()
    {
        return isset($this->filter['filter_position']) ? $this->filter['filter_position'] : 0;
    }

    public function inputType()
    {
        return isset($this->filter['input_type']) ? $this->filter['input_type'] : null;
    }

    public function isDateInput()
    {
        return $this->inputType() == 'Date';
    }

    public function isDropDown()
    {
        return $this->inputType() == 'Drop Down';
    }

    public function isHidden()
    {
        return $this->inputType() == 'hidden';
    }

    public function get($key)
    {
        return isset($this->filter[$key]) ? $this->filter[$key] : null;
    }

    public function dropdownSql()
    {
        if (! isset($this->filter['drop_down_sql'])) {
            return null;
        }

        if ($this->filter['drop_down_sql'] == 'N/A') {
            return null;
        }

        return $this->filter['drop_down_sql'];
    }
}
