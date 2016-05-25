<?php

namespace App\Http\Modules\loaddata\School\Models;

use PHPExcel_Cell;
use PHPExcel_Cell_DataType;
use PHPExcel_Cell_IValueBinder;
use PHPExcel_Cell_DefaultValueBinder;

/**
 * This will treat all excel rows as strings
 */
class ExcelValueBinder extends PHPExcel_Cell_DefaultValueBinder implements PHPExcel_Cell_IValueBinder
{
    public function bindValue(PHPExcel_Cell $cell, $value = null)
    {

        dd($cell, $value);
        $cell->setValueExplicit($value, PHPExcel_Cell_DataType::TYPE_STRING2);
        return true;
    }
}
