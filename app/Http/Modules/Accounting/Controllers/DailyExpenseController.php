<?php

namespace App\Http\Modules\Accounting\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Accounting\Models\DailyExpense;
use App\Http\Modules\Accounting\Requests\DailyExpenseFormRequest;

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
        $expense = new DailyExpense;
        return view('modules.accounting.DailyExpense.form', compact('expense'));
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
        return redirect('/cabinet/daily-expense');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expense = DailyExpense::findOrFail($id);
        return view('modules.accounting.DailyExpense.form', compact('expense'));
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
        return redirect('/cabinet/daily-expense');
    }
}
