<?php

namespace App\Http\Modules\reports\Accounting\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\reports\Accounting\Models\ReceiptPrintPDF;
use App\Http\PdfGenerator\Pdf;

class ReceiptPrintPDFController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . ReceiptPrintPDF::screenId());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        $export = new ReceiptPrintPDF;
        $export->setAttribute('report_id', $request->input('id'));
        $export->loadPdfData();
        $view = view('reports.accounting.ReceiptPrint.pdf', compact('export'));
        return Pdf::render($view);
    }
}
