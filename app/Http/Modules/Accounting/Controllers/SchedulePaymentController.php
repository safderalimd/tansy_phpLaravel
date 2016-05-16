<?php

namespace App\Http\Modules\Accounting\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Accounting\Models\SchedulePayment;
use App\Http\Modules\Accounting\Requests\SchedulePaymentFormRequest;

class SchedulePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment = new SchedulePayment;
        return view('modules.accounting.SchedulePayment.list', compact('payment'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $payment = new SchedulePayment;
        return view('modules.accounting.SchedulePayment.form', compact('payment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SchedulePaymentFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SchedulePaymentFormRequest $request)
    {
        $payment = new SchedulePayment($request->input());

        if ($payment->save()) {
            return redirect('/cabinet/schedule-payment');
        }

        return redirect('/cabinet/schedule-payment/create')->withErrors($payment->getErrors());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment = SchedulePayment::findOrFail($id);
        return view('modules.accounting.SchedulePayment.form', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SchedulePaymentFormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(SchedulePaymentFormRequest $request, $id)
    {
        $payment = SchedulePayment::findOrFail($id);

        if ($payment->update($request->input())) {
            return redirect('/cabinet/schedule-payment');
        }

        return redirect(url('/cabinet/schedule-payment/edit', compact('id')))
            ->withErrors($payment->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = SchedulePayment::findOrFail($id);

        if ($payment->delete()) {
            return redirect('/cabinet/schedule-payment');
        }

        return redirect('/cabinet/schedule-payment')->withErrors($payment->getErrors());
    }
}
