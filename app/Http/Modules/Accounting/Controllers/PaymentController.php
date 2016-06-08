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
        $primaryKey = $request->input('pk');
        $payment = Payment::details($primaryKey);
        return view('modules.accounting.Payment.form', compact('payment', 'primaryKey'));
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
        $payment->payNow();
        return redirect('/cabinet/payment');
    }
}
