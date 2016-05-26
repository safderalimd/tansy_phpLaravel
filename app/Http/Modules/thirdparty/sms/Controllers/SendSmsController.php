<?php

namespace App\Http\Modules\thirdparty\sms\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\thirdparty\sms\Models\SendSms;
use App\Http\Modules\thirdparty\sms\Requests\SendSmsFormRequest;

class SendSmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sms = new SendSms;
        return view('thirdparty.sms.SendSms.list', compact('sms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sms = new SendSms;
        return view('thirdparty.sms.SendSms.form', compact('sms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SendSmsFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SendSmsFormRequest $request)
    {
        $sms = new SendSms($request->input());

        if ($sms->save()) {
            return redirect('/cabinet/send-sms');
        }

        return redirect('/cabinet/send-sms/create')->withErrors($sms->getErrors());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sms = SendSms::findOrFail($id);
        return view('thirdparty.sms.SendSms.form', compact('sms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SendSmsFormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(SendSmsFormRequest $request, $id)
    {
        $sms = SendSms::findOrFail($id);

        if ($sms->update($request->input())) {
            return redirect('/cabinet/send-sms');
        }

        return redirect(url('/cabinet/send-sms/edit', compact('id')))
            ->withErrors($sms->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sms = SendSms::findOrFail($id);

        if ($sms->delete()) {
            return redirect('/cabinet/send-sms');
        }

        return redirect('/cabinet/send-sms')->withErrors($sms->getErrors());
    }
}
