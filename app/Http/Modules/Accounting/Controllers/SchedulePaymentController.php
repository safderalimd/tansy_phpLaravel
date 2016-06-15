<?php

namespace App\Http\Modules\Accounting\Controllers;

use Illuminate\Http\Request;
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
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // this is a link request from payment grid
        $accountEntityId = null;
        if (!empty($request->input('aei'))) {
            $accountEntityId = $request->input('aei');
        }
        $payment = new SchedulePayment;
        return view('modules.accounting.SchedulePayment.form', compact('payment', 'accountEntityId'));
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
        $payment->save();
        flash('Schedule Payment Added!');
        return redirect('/cabinet/schedule-payment');
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
        $payment->loadData();
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
        $payment = new SchedulePayment;
        $payment->setAttribute('schedule_entity_id', $id);
        $payment->setAttribute('active', 0);

        $payment->update($request->input());
        flash('Schedule Payment Updated!');
        return redirect('/cabinet/schedule-payment');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = new SchedulePayment;
        $payment->setAttribute('schedule_entity_id', $id);
        $payment->delete();
        flash('Schedule Payment Deleted!');
        return redirect('/cabinet/schedule-payment');
    }

    public function createStudent(Request $request)
    {
        // this is a link request from payment grid
        $accountEntityId = null;
        if (!empty($request->input('aei'))) {
            $accountEntityId = $request->input('aei');
        }
        $payment = new SchedulePayment;
        return view('modules.accounting.SchedulePayment.form-student', compact('payment', 'accountEntityId'));
    }

    public function storeStudent(SchedulePaymentFormRequest $request)
    {
        $payment = new SchedulePayment($request->input());
        $payment->save();
        flash('Schedule Payment Added!');
        return redirect('/cabinet/student-account');
    }
}
