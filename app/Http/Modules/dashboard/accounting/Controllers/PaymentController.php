<?php

namespace App\Http\Modules\dashboard\accounting\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\dashboard\accounting\Models\Payment;
use App\Http\Modules\dashboard\accounting\Requests\PaymentFormRequest;

class PaymentController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:'.Payment::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $payment = new Payment;
        $payment->setCollectionFilter($request->input('fi'));
        $payment->loadData();
        return view('dashboard.accounting.Payment.list', compact('payment'));
    }

    public function scheduleFee()
    {
        $payment = new Payment;
        return view('dashboard.accounting.Payment.schedule-fee', compact('payment'));
    }

    public function discount()
    {
        $payment = new Payment;
        return view('dashboard.accounting.Payment.discount', compact('payment'));
    }
}
