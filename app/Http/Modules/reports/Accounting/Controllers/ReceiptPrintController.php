<?php

namespace App\Http\Modules\reports\Accounting\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\reports\Accounting\Models\ReceiptPrint;
use App\Http\Modules\reports\Accounting\Requests\ReceiptPrintFormRequest;
use App\Http\PdfGenerator\Pdf;

class ReceiptPrintController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . ReceiptPrint::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $receipt = new ReceiptPrint;
        $receipt->setAttribute('account_entity_id', $id);
        return view('reports.accounting.ReceiptPrint.list', compact('receipt'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function report($id)
    {
        $export = new ReceiptPrint;
        $export->setAttribute('report_id', $id);
        $export->loadPdfData();
        $view = view('reports.accounting.ReceiptPrint.pdf', compact('export'));
        return Pdf::render($view);
    }
}
