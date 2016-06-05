<?php

namespace App\Http\Modules\Accounting\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Accounting\Models\PaymentAdjustment;
use App\Http\Modules\Accounting\Requests\PaymentAdjustmentFormRequest;
use Illuminate\Http\Request;

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
        $adjustment->setAttribute('filter_type', 'Individual');
        $adjustment->setAttribute('return_type', 'Detail'); // or Summary
        $adjustment->setAttribute('subject_entity_id', $id);

        $rows = $adjustment->getAll();

        return view('modules.accounting.PaymentAdjustment.list', compact('adjustment', 'rows'));
    }

    /**
     * Load add form.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $adjustment = new PaymentAdjustment($request->input());
        $processForm = $request->input('process_form');

        if ($processForm) {
            // process the edit form submit and update the database
            $adjustment->setAttribute('total_scheduled_amount', $adjustment->total_amount);
            $adjustment->setAttribute('credited_to_entity_id', $adjustment->account_entity_id);

            if (!is_numeric($adjustment->adjustment_amount)) {
                $errors = ['Adjustment amount must be a number.'];
                return view('modules.accounting.PaymentAdjustment.form', compact('adjustment', 'errors'));
            }
            if (empty($adjustment->adjustment_amount)) {
                $errors = ['Adjustment amount is required.'];
                return view('modules.accounting.PaymentAdjustment.form', compact('adjustment', 'errors'));
            }

            if ($adjustment->save()) {
                return redirect('/cabinet/payment-adjustment/'.$adjustment->account_entity_id);
            }
            $errors = [$adjustment->getErrors()];
            return view('modules.accounting.PaymentAdjustment.form', compact('adjustment', 'errors'));

        } else {
            // just display the edit form with populated data
            return view('modules.accounting.PaymentAdjustment.form', compact('adjustment'));
        }
    }

    /**
     * Edit form.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return $this->add($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $adjustment = new PaymentAdjustment($request->input());
        $adjustment->delete();
        return \Redirect::back();
    }
}
