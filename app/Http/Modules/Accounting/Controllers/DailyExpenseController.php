<?php

namespace App\Http\Modules\Accounting\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Accounting\Models\DailyExpense;
use App\Http\Modules\Accounting\Requests\DailyExpenseFormRequest;
use URL;

class DailyExpenseController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . DailyExpense::screenId());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $queryString = $this->getGridFilters();
        $expense = new DailyExpense;
        return view('modules.accounting.DailyExpense.form', compact('expense', 'queryString'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DailyExpenseFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DailyExpenseFormRequest $request)
    {
        $expense = new DailyExpense($request->input());
        $expense->save();
        flash('Daily Expense Added!');
        return redirect('/cabinet/daily-expense'.$expense->grid_filter_value);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $queryString = $this->getGridFilters();
        $expense = DailyExpense::find($id);
        return view('modules.accounting.DailyExpense.form', compact('expense', 'queryString'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DailyExpenseFormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(DailyExpenseFormRequest $request, $id)
    {
        $expense = new DailyExpense($request->input());
        $expense->setAttribute('expense_id', $id);
        $expense->update();
        flash('Daily Expense Updated!');
        return redirect('/cabinet/daily-expense'.$expense->grid_filter_value);
    }

    public function getGridFilters()
    {
        $previousUrl = URL::previous();

        $poz = strpos($previousUrl, '/daily-expense?');
        $filter = '';
        if ($poz !== false) {
            $filter = substr($previousUrl, $poz + 14);
        }

        return $filter;
    }
}
