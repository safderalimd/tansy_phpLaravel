<?php

namespace App\Http\Modules\reports\Accounting\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\reports\Accounting\Models\ReceiptPrint;

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
    public function index(Request $request)
    {
        $receipt = new ReceiptPrint;
        $receipt->setAttribute('account_entity_id', $request->input('id'));
        return view('reports.accounting.ReceiptPrint.list', compact('receipt'));
    }
}
