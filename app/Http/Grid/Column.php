<?php

namespace App\Http\Grid;

class Column
{
    protected $column;

    protected $buttons = null;

    public function __construct($column)
    {
        $this->column = $column;
    }

    public function position()
    {
        return isset($this->column['column_position']) ? $this->column['column_position'] : 0;
    }

    public function isVisible()
    {
        return (isset($this->column['visible']) && $this->column['visible'] == 1) ? true : false;
    }

    public function label()
    {
        return isset($this->column['ui_label']) ? $this->column['ui_label'] : 'N/A';
    }

    public function isSortable()
    {
        return (isset($this->column['sortable']) && $this->column['sortable'] == 1) ? true : false;
    }

    public function name()
    {
        return isset($this->column['db_clumn_name']) ? $this->column['db_clumn_name'] : null;
    }

    public function format()
    {
        return isset($this->column['data_format']) ? $this->column['data_format'] : null;
    }

    public function hasMobileFormat()
    {
        return $this->format() == 'phone';
    }

    public function hasDateFormat()
    {
        return $this->format() == 'date';
    }

    public function hasCurrencyFormat()
    {
        return $this->format() == 'currency';
    }

    public function hasNumberFormat()
    {
        return $this->format() == 'number';
    }

    public function hasLinkFormat()
    {
        $format = $this->format();
        return strpos($format, 'link:') !== false;
    }

    public function link($row)
    {
        $format = $this->format();
        $urlColumn = explode(':', $format);

        if (! isset($urlColumn[1])) {
            return '#';
        }

        $urlColumn = trim($urlColumn[1]);

        if (! isset($row[$urlColumn])) {
            return '#';
        }

        return '/' . ltrim($row[$urlColumn], '/');
    }

    public function hasButtonFormat()
    {
        $format = $this->format();
        return strpos($format, 'button_link:') !== false;
    }

    public function getButtons()
    {
        if (!is_null($this->buttons)) {
            return $this->buttons;
        }

        $format = $this->format();
        $buttonsList = explode(':', $format);
        if (! isset($buttonsList[1])) {
            return [];
        }

        $buttons = [];
        $buttonsList = $buttonsList[1];
        $buttonsList = explode('|', $buttonsList);
        foreach ($buttonsList as $button) {
            $tmp = explode(',', $button);
            if (isset($tmp[0]) && isset($tmp[1])) {
                $buttons[] = [
                    'link'  => trim($tmp[0]),
                    'label' => trim($tmp[1]),
                ];
            }
        }
        $this->buttons = $buttons;
        return $this->buttons;
    }
}
