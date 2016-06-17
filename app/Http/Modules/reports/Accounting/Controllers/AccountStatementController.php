<?php

namespace App\Http\Modules\reports\Accounting\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\reports\Accounting\Models\AccountStatement;
use App\Http\Modules\reports\Accounting\Requests\AccountStatementFormRequest;
use App\Http\PdfGenerator\Pdf;

class AccountStatementController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . AccountStatement::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $export = new AccountStatement;
        return view('reports.accounting.AccountStatement.list', compact('export'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        $export = new AccountStatement($request->input());
        $export->loadPdfData();
        $view = view('reports.accounting.AccountStatement.pdf', compact('export'));
        return Pdf::render($view);
    }
}
