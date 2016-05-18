<?php

namespace App\Http\Modules\Accounting\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Accounting\Models\PaymentAdjustment;
use App\Http\Modules\Accounting\Requests\PaymentAdjustmentFormRequest;

class PaymentAdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $adjustment = new PaymentAdjustment;
        $adjustment->setAttribute('filter_type', 'entity');
        $adjustment->setAttribute('return_type', 'Detail'); // or Summary
        $adjustment->setAttribute('subject_entity_id', $id);

        $rows = $adjustment->getAll();

        return view('modules.accounting.PaymentAdjustment.list', compact('adjustment', 'rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $adjustment = new PaymentAdjustment;
        return view('modules.accounting.PaymentAdjustment.form', compact('adjustment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PaymentAdjustmentFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentAdjustmentFormRequest $request)
    {
        $adjustment = new PaymentAdjustment($request->input());

        if ($adjustment->save()) {
            return redirect('/cabinet/payment-adjustment');
        }

        return redirect('/cabinet/payment-adjustment/create')->withErrors($adjustment->getErrors());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $adjustment = PaymentAdjustment::findOrFail($id);
        return view('modules.accounting.PaymentAdjustment.form', compact('adjustment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PaymentAdjustmentFormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentAdjustmentFormRequest $request, $id)
    {
        $adjustment = PaymentAdjustment::findOrFail($id);

        if ($adjustment->update($request->input())) {
            return redirect('/cabinet/payment-adjustment');
        }

        return redirect(url('/cabinet/payment-adjustment/edit', compact('id')))
            ->withErrors($adjustment->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adjustment = PaymentAdjustment::findOrFail($id);

        if ($adjustment->delete()) {
            return redirect('/cabinet/payment-adjustment');
        }

        return redirect('/cabinet/payment-adjustment')->withErrors($adjustment->getErrors());
    }
}
