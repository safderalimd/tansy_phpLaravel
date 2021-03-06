<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Models\Grid;
use App\Http\FPDF\Grid\GridPDF;
use Device;

class GridController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $grid = new Grid('/' . $request->path());
        $this->middleware('screen:' . $grid->getScreenId());
    }

    public function index(Request $request)
    {
        if ($request->input('pdf') == '1') {
            return $this->pdf($request);
        }

        $grid = new Grid('/' . $request->path());
        $grid->fill($request->input());
        $grid->loadData();

        if ($grid->settings->showPdf()) {
            return view('grid.PDF.filters-list', compact('grid'));
        }
        return view('grid.list', compact('grid'));
    }

    public function pdf(Request $request)
    {
        $grid = new Grid('/' . $request->path());
        $grid->fill($request->input());
        $grid->loadData();

        if (Device::isAndroidMobile()) {
            $options = ['isPdf' => true];
            return view('grid.PDF.pdf', compact('grid', 'options'));
        } else {
            $pdf = (count($grid->columns()) > 4) ? GridPDF::landscape() : GridPDF::portrait();
            $pdf->generate($grid);
        }
    }
}
