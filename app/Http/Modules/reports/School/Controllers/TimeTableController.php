<?php

namespace App\Http\Modules\reports\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\reports\School\Models\TimeTable;
use App\Http\FPDF\TimeTable\TimeTablePDF;
use Device;

class TimeTableController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . TimeTable::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $export = new TimeTable;
        return view('reports.school.TimeTable.list', compact('export'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        $export = new TimeTable($request->input());
        $export->loadData();

        if (Device::isAndroidMobile()) {
            return view('reports.school.TimeTable.pdf', compact('export'));
        } else {
            TimeTablePDF::landscape()->generate($export);
        }
    }
}
