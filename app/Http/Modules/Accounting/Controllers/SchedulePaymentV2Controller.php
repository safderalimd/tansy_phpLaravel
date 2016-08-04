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
            'headerLastInclude' => 'modules.accounting.SchedulePayment.header-last-include',
            'rowLastInclude'    => 'modules.accounting.SchedulePayment.row-last-include',
            'afterGridInclude'   => 'modules.accounting.SchedulePayment.after-grid-include',
            'scriptsInclude'     => 'modules.accounting.SchedulePayment.scripts-include',
        ];

        return view('grid.list', compact('grid', 'options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SchedulePaymentV2FormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(SchedulePaymentV2FormRequest $request, $id)
    {
        $payment = new SchedulePaymentV2;
        $payment->setAttribute('schedule_entity_id', $id);
        $payment->setAttribute('active', 0);

        $payment->update($request->input());
        flash('Schedule Payment Updated!');
        return redirect('/cabinet/schedule-payment-v2');
    }
}
