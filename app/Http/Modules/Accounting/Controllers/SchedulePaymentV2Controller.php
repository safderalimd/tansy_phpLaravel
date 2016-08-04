<?php

namespace App\Http\Modules\Accounting\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Accounting\Models\SchedulePaymentV2;
use App\Http\Modules\Accounting\Requests\SchedulePaymentV2Repository;
use App\Http\Models\Grid;

class SchedulePaymentV2Controller extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . SchedulePaymentV2::screenId());
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
            'headerLastInclude'  => 'modules.accounting.SchedulePaymentV2.header-last-include',
            'rowLastInclude'     => 'modules.accounting.SchedulePaymentV2.row-last-include',
            'beforeGridInclude'  => 'modules.accounting.SchedulePaymentV2.before-grid-include',
            'afterGridInclude'   => 'modules.accounting.SchedulePaymentV2.after-grid-include',
            'scriptsInclude'     => 'modules.accounting.SchedulePaymentV2.scripts-include',
        ];

        return view('grid.list', compact('grid', 'options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $payment = new SchedulePaymentV2($request->input());
        dd($payment);
        $payment->update();
        flash('Schedule Payments Updated!');
        return redirect('/cabinet/schedule-payment-v2');
    }
}
