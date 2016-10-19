<?php

namespace App\Http\Modules\reports\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\reports\School\Models\DICE;
use App\Http\FPDF\DICE\DICEPDF;
use App\Http\CSVGenerator\CSV;
use Device;

class DICEController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . DICE::screenId());
    }

    public function index()
    {
        return view('reports.school.DICE.list');        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        $export = new DICE($request->input());
        $export->setOwnerOrganizationInfo();

        if (Device::isAndroidMobile()) {
            return view('reports.school.DICE.pdf', compact('export'));
        } else {
            DICEPDF::landscape()->generate($export);
        }
    }

    public function csv(Request $request)
    {
        $export = new DICE($request->input());
        $dice = $export->dice();

        $firstRow = $dice->first();
        $headerRow = $firstRow->groupBy('measure_type');

        $header = ['Class'];
        foreach ($headerRow as $cell => $subTypes) {
            $header[] = $cell;
            for ($i=0; $i < count($subTypes)-1; $i++) { 
                $header[] = '';
            }
        }

        $secondRow = [''];
        foreach ($headerRow as $cell => $subTypes) {
            foreach ($subTypes as $subType) {
                $secondRow[] = $subType['measure_sub_type'];
            }
        }

        $rows = [];
        foreach ($dice as $diceRow) {
            $oneRow = [];
            $row = $diceRow->groupBy('measure_type'); 
            $className = $row->first()->first()['class_name'];
            $oneRow[] = $className;
            foreach ($row as $cell => $subTypes) {
                foreach ($subTypes as $subType) {
                    $oneRow[] = $subType['student_count'];
                }
            }
            $rows[] = $oneRow;
        }

        array_unshift($rows, $secondRow);
        return CSV::make($header, $rows);
    }
}
