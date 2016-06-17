<?php

namespace App\Http\Modules\Accounting\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Accounting\Models\CashCounter;

class CashCounterController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:'.CashCounter::screenId());
    }

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
        $cash = new CashCounter($request->input());
        $cash->closeCounter();
        flash('Cash Counter Closed!');
        return redirect('/cabinet/close-cash-counter');
    }
}
