<?php

namespace App\Http\Modules\reports\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\reports\School\Models\StudentDetail;
use App\Http\Models\Grid;
use App\Http\FPDF\Grid\GridPDF;
use Device;

class StudentDetailController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . StudentDetail::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $grid = new Grid('/' . $request->path());
        $grid->fill($request->input());
        $grid->loadData();
        return view('reports.school.StudentDetail.list', compact('grid'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        $export = new StudentDetail($request->input());
        if ($export->rt == 'pdf') {

            $grid = new Grid($export->getScreenIdProperty());
            $grid->fill($request->input());
            $grid->loadData();
            $grid->removeUnsetColumns($export);

            if (Device::isAndroidMobile()) {
                $options = ['isPdf' => true];
                return view('grid.PDF.pdf', compact('grid', 'options'));
            } else {
                $pdf = (count($grid->columns()) > 4) ? GridPDF::landscape() : GridPDF::portrait();
                $pdf->generate($grid);
            }

        } else {

            $grid = new Grid($export->getScreenIdProperty());
            $grid->fill($request->input());
            $grid->loadData();
            $grid->removeUnsetColumns($export);

            $columnRow = [];
            $columns = $grid->columns();
            foreach ($columns as $column) {
                $columnRow[] = $column->label();
            }

            $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
            $csv->insertOne($columnRow);

            foreach ($grid->rows() as $row) {
                $rowData = [];
                foreach($columns as $column) {
                    if (isset($row[$column->name()])) {
                        $rowData[] = $row[$column->name()];
                    } else {
                        $rowData[] = '';
                    }
                }

                $csv->insertOne($rowData);
            }

            $csv->output('report.csv');
            die();
        }
    }
}
