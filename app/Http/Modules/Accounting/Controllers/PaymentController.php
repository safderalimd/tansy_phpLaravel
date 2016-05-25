<?php

namespace App\Http\Modules\Accounting\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Accounting\Models\Payment;
use App\Http\Modules\Accounting\Requests\PaymentFormRequest;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rowType = $request->input('rt');
        $primaryKey = $request->input('pk');
        $payment = Payment::summary($rowType, $primaryKey);
        return view('modules.accounting.Payment.list', compact('payment', 'primaryKey', 'rowType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $rowType = $request->input('rt');
        $primaryKey = $request->input('pk');
        $payment = Payment::details($rowType, $primaryKey);

        return view('modules.accounting.Payment.form', compact('payment', 'primaryKey', 'rowType'));
    }

    /**
     * Pay now.
     *
     * @param PaymentFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function payNow(PaymentFormRequest $request)
    {
        $payment = new Payment($request->input());

        // TODO: make sure the payment calculations are validated in php again here

        if ($payment->payNow()) {
            return redirect('/cabinet/payment');
        }

        return \Redirect::back()->withErrors($payment->getErrors());
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
