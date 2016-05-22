<?php

namespace App\Http\Modules\reports\Accounting\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\reports\Accounting\Models\ReceiptPrint;
use App\Http\Modules\reports\Accounting\Requests\ReceiptPrintFormRequest;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReceiptPrintController extends Controller
{
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
        $html = $view->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'letter');
        $dompdf->render();

        $output = $dompdf->output();
        return response($output)
            ->header('Content-Type', 'application/pdf')
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }

}
