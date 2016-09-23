<?php

namespace App\Http\Modules\reports\Accounting\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\reports\Accounting\Models\ReceiptPrintPDF;
use App\Http\FPDF\ReceiptPrint\ReceiptV1PDF;
use App\Http\FPDF\ReceiptPrint\ReceiptV2PDF;
use App\Http\FPDF\ReceiptPrint\ReceiptV2Contents;
use Device;

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

    public function reportV1(Request $request)
    {
        $export = new ReceiptPrintPDF($request->input());
        $export->loadPdfDataV1();

        if (Device::isAndroidMobile()) {
            return view('reports.accounting.ReceiptPrint.pdf-v1', compact('export'));
        } else {
            ReceiptV1PDF::portrait()->generate($export);
        }
    }

    public function reportV2(Request $request)
    {
        $export = new ReceiptPrintPDF($request->input());

        if (Device::isAndroidMobile()) {
            return view('reports.accounting.ReceiptPrint.pdf-v2', ['export' => new ReceiptV2Contents($export)]);
        } else {
            ReceiptV2PDF::portrait()->generate($export);
        }
    }
}
