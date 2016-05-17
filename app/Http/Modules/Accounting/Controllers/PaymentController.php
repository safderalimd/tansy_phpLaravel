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
        $payment = new Payment;
        $rowType = $request->input('rt');
        $primaryKey = $request->input('pk');

        if (!empty($rowType) && !empty($primaryKey)) {
            $payment->setAttribute('return_type', 'Detail'); // 'Summary' or 'Detail'
            $payment->setAttribute('filter_type', $rowType);
            $payment->setAttribute('subject_entity_id', $primaryKey);
            $rows = $payment->getAllPayments();
        } else {
            $rows = null;
        }

        // Todo: treat sql errors in this case (redirect with errors)

        return view('modules.accounting.Payment.list', compact('payment', 'primaryKey', 'rowType', 'rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $payment = new Payment;
        $rowType = $request->input('rt');
        $primaryKey = $request->input('pk');

        // iparam_filter_type = 'entity'
        // iparam_subject_entity_id = account_entity_id
        // iparam_return_type = Detail
        if (!empty($rowType) && !empty($primaryKey)) {
            $payment->setAttribute('filter_type', 'entity');
            $payment->setAttribute('subject_entity_id', $primaryKey);
            $payment->setAttribute('return_type', 'Detail'); // 'Summary' or 'Detail'
            $rows = $payment->getAllPayments();
        } else {
            $rows = null;
        }

        dd($rows);

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
