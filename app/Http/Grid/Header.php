<?php

namespace App\Http\Grid;

class Header
{
    protected $columns = [];

    protected $visibleColumns;

    protected $buttonColumns;

    public function __construct($columns)
    {
        foreach ($columns as $column) {
            $this->columns[] = new Column($column);
        }

        $this->sortColumns();

        $this->visibleColumns = $this->getVisibleColumns();
        $this->buttonColumns  = $this->getButtonColumns();
    }

    public function columns()
    {
        return $this->visibleColumns;
    }

    public function buttons()
    {
        return $this->buttonColumns;
    }

    public function sortColumns()
    {
        usort($this->columns, function($a, $b) {
            return $a->position() > $b->position();
        });
    }

    public function getVisibleColumns()
    {
        $visible = [];
        foreach ($this->columns as $column) {
            if ($column->isVisible() && !$column->hasButtonFormat()) {
                $visible[] = $column;
            }
        }

        return $visible;
    }

    public function getButtonColumns()
    {
        $visible = [];
        foreach ($this->columns as $column) {
            if ($column->isVisible() && $column->hasButtonFormat()) {
                $visible[] = $column;
            }
        }

        return $visible;
    }

    public function removeUnsetColumns($model)
    {
        foreach ($this->visibleColumns as $key => $column) {
            if (!isset($model->{$column->name()})) {
                unset($this->visibleColumns[$key]);
            }
        }
    }
}
