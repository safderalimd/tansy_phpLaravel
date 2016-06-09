<?php

namespace App\Http\Modules\Accounting\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Accounting\Models\CashCounter;

class CashCounterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cash = new CashCounter;
        return view('modules.accounting.CashCounter.list', compact('cash'));
    }

    public function closeCashCounter(Request $request)
    {
        dd($request->input());

        flash('Cash Counter Closed!');
    }
}
