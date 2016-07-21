<?php

namespace App\Http\Modules\Accounting\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Accounting\Models\CashCounter;
use App\Http\Models\Grid;

class CashCounterController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . CashCounter::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $grid = new Grid('/' . $request->path());
        $grid->fill($request->input());
        $grid->loadData();

        $options = [
            'headerLastInclude' => 'modules.accounting.CashCounter.header-last-include',
            'rowLastInclude'    => 'modules.accounting.CashCounter.row-last-include',
            'beforeGridInclude'   => 'modules.accounting.CashCounter.before-grid-include',
            'afterGridInclude'   => 'modules.accounting.CashCounter.after-grid-include',
            'scriptsInclude'     => 'modules.accounting.CashCounter.scripts-include',
        ];

        return view('grid.list', compact('grid', 'options'));

        // $cash = new CashCounter;
        // return view('modules.accounting.CashCounter.list', compact('cash'));
    }

    public function closeCashCounter(Request $request)
    {
        $cash = new CashCounter($request->input());
        $cash->closeCounter();
        flash('Cash Counter Closed!');
        return redirect('/cabinet/close-cash-counter');
    }
}
