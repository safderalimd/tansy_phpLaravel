<?php

namespace App\Http\Modules\thirdparty\sms\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\thirdparty\sms\Models\SendSms;
use App\Http\Modules\thirdparty\sms\Requests\SendSmsFormRequest;
use App\Http\Modules\thirdparty\sms\SmsSender;

class SendSmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sms = new SendSms;
        $sms->setAttribute('sms_type_id', $request->input('sti'));
        $sms->setAttribute('sms_account_entity_id', $request->input('aei'));
        $sms->setAttribute('sms_account_row_type', $request->input('art'));
        $sms->setAttribute('exam_entity_id', $request->input('eei'));
        $sms->loadData();
        return view('thirdparty.sms.SendSms.list', compact('sms'));
    }

    public function store()
    {

    }

    public function send()
    {
        // todo: validate message length <= 160 chars

        try {

            // Abhilash G (X-A) (8801933344)
            // Anurag G (X-A) (9603384881)

            $message = 'This is a test sms message';
            $messages = [
                ['number' => 234, 'text' => 'Test sms message #1'],
                ['number' => 554, 'text' => 'Test sms message #2'],
            ];

            $test = true;
            $sender = SmsSender::send($messages, $test);

            d($sender->getXmlData());
            d($sender->getRawResponse());
            dd($sender->getResult());

            // read batch status
            // $batchStatus = $textlocal->getBatchStatus($result->batch_id);
            // dd($batchStatus);

        } catch (\Exception $e) {

            // todo: redirect back to view, and display error message
            // todo: log error, mail admin
            dd($e);
        }

        // todo: redirect back with success flash message

        dd('---');
    }

}
