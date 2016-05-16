<?php

namespace App\Http\Modules\Accounting\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Accounting\Models\Payment;
use App\Http\Modules\Accounting\Requests\PaymentFormRequest;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment = new Payment;
        return view('modules.accounting.Payment.list', compact('payment'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $payment = new Payment;
        return view('modules.accounting.Payment.form', compact('payment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PaymentFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentFormRequest $request)
    {
        $payment = new Payment($request->input());

        if ($payment->save()) {
            return redirect('/cabinet/payment');
        }

        return redirect('/cabinet/payment/create')->withErrors($payment->getErrors());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        return view('modules.accounting.Payment.form', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PaymentFormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentFormRequest $request, $id)
    {
        $payment = Payment::findOrFail($id);

        if ($payment->update($request->input())) {
            return redirect('/cabinet/payment');
        }

        return redirect(url('/cabinet/payment/edit', compact('id')))
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
        $payment = Payment::findOrFail($id);

        if ($payment->delete()) {
            return redirect('/cabinet/payment');
        }

        return redirect('/cabinet/payment')->withErrors($payment->getErrors());
    }
}
