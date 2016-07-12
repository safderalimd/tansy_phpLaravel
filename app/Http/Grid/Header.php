<?php

namespace App\Http\Grid;

class Header
{
    protected $columns = [];

    protected $visibleColumns;

    public function __construct($columns)
    {
        foreach ($columns as $column) {
            $this->columns[] = new Column($column);
        }

        $this->sortColumns();

        $this->visibleColumns = $this->getVisibleColumns();
    }

    public function columns()
    {
        return $this->visibleColumns;
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
            if ($column->isVisible()) {
                $visible[] = $column;
            }
        }
        return $visible;
    }
}
