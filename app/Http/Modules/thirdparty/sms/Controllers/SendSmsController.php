<?php

namespace App\Http\Modules\thirdparty\sms\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\thirdparty\sms\Models\SendSms;
use App\Http\Modules\thirdparty\sms\Requests\SendSmsFormRequest;

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
        // textlocal rules:
            // - if i try to send to more valid numbers thant my balance, i will get an error
            // - if i specify no numbers, i get an error
            // - if i specify the same number twice, then 2 messages will be sent to that number
            // - i get a new balance after every api call; then update the total balance; but this way is not right: what if in the db is the correct balance, but then i buy more credits, then this balance will not be updated correctly until i send a new api call (what if the balance is 0 in the db, then when i buy more credits they won't be able to send new messages because the balance in the db is 0)

        // log, sms message, numbers we sent to (by account id); Question: if in the future the student changes the phone number, do we log only the student id or the number too?

        // todo: validate message length <= 160 chars
        // get real numbers from ids

        // setup textlocal api keys
        $username = 'safderalimd@outlook.com';
        $hash = '8989b55b912599b9c2793c087e23a1ecd9913e15';

        // DND: 9440090105, 8688388595, 9705859123, 9912173611, 9989165456, 9848811617, 9948038595

        // 9491730595, 9490111595, 9493370595, 9966755595, 9030568595, 9493375595, 9849134115, 9955448877, 9493315103,

        // 9849917468, 9849917468, 9293951595, 9948038595, 7702416595, 949173059,

        $numbers = [9491730595];
        $message = 'This is a test sms message';
        $sender = 'TXTLCL';
        $schedule = null;
        $test = true;

        // include textlocal library
        $path = app_path('Http/Modules/thirdparty/sms/vendor/textlocal/textlocal.class.php');
        require_once($path);

        try {
            // send sms messages
            $textlocal = new \Textlocal($username, $hash);
            $result = $textlocal->sendSms($numbers, $message, $sender, $schedule, $test);
            d($result);

            // todo: get the new balance

            // read batch status
            $batchStatus = $textlocal->getBatchStatus($result->batch_id);
            dd($batchStatus);

        } catch (\Exception $e) {

            // todo: redirect back to view, and display error message
            // todo: log error, mail admin
            dd($e);
        }

        // todo: redirect back with success flash message

        dd('---');
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     $sms = new SendSms;
    //     return view('thirdparty.sms.SendSms.form', compact('sms'));
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param SendSmsFormRequest $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(SendSmsFormRequest $request)
    // {
    //     $sms = new SendSms($request->input());

    //     if ($sms->save()) {
    //         return redirect('/cabinet/send-sms');
    //     }

    //     return redirect('/cabinet/send-sms/create')->withErrors($sms->getErrors());
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     $sms = SendSms::findOrFail($id);
    //     return view('thirdparty.sms.SendSms.form', compact('sms'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param SendSmsFormRequest $request
    //  * @param  int $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(SendSmsFormRequest $request, $id)
    // {
    //     $sms = SendSms::findOrFail($id);

    //     if ($sms->update($request->input())) {
    //         return redirect('/cabinet/send-sms');
    //     }

    //     return redirect(url('/cabinet/send-sms/edit', compact('id')))
    //         ->withErrors($sms->getErrors());
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     $sms = SendSms::findOrFail($id);

    //     if ($sms->delete()) {
    //         return redirect('/cabinet/send-sms');
    //     }

    //     return redirect('/cabinet/send-sms')->withErrors($sms->getErrors());
    // }
}
