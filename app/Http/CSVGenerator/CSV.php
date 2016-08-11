<?php

namespace App\Http\CSVGenerator;

use Illuminate\Http\Request;
use League\Csv\Writer;
use SplTempFileObject;

class CSV
{
    public static function make($header, $rows)
    {
        $csv = Writer::createFromFileObject(new SplTempFileObject());
        $csv->insertOne($header);

        foreach ($rows as $row) {
            $csv->insertOne($row);
        }

        $csv->output('report.csv');
        die();
    }
}
