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
        $sms->setRequestAttributes($request);
        $sms->loadData();
        return view('thirdparty.sms.SendSms.list', compact('sms'));
    }

    /**
     * Send sms messages
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sms = new SendSms;
        $sms->setRequestAttributes($request);
        $sms->loadData();

        // validate student ids
        $this->validate($request, ['student_ids' => 'required|string']);

        // get rows from db with selected account ids; do this before anything else to load data
        $dbRows = $sms->rows();

        // if sms type is different than fee reminder or exam result, use common message
        $useCommonMessage = false;
        if (!$sms->smsIsOfType('Fee Reminder') && !$sms->smsIsOfType('Exam Result')) {
            $this->validate($request, ['common_message' => 'required|string|max:160']);
            $useCommonMessage = true;
        }

        $studentIds = explode(',', $request->input('student_ids'));
        $validRows = array_filter($dbRows, function($row) use ($studentIds) {
            return in_array($row['account_entity_id'], $studentIds);
        });

        // apply the message to the rows
        $validRows = array_map(function($row) use ($useCommonMessage, $request) {
            if ($useCommonMessage) {
                $row['sms_text'] = $request->input('common_message');
            } elseif (isset($row['due_amount'])) {
                $row['sms_text'] = ' Your current due is ' . amount($row['due_amount']);
            }
            return $row;
        }, $validRows);

        try {
            $sender = SmsSender::send($validRows);
        } catch (\Exception $e) {

            d($validRows);
            d($sender->getXmlData());
            dd($sender->getRawResponse());

            return \Redirect::back()->withErrors([$e->getMessage()]);
        }

        // todo: need to calculate credits used, success count, failure count

        $accountIds = array_map(function($item) {
            return $item['account_entity_id'] . '-' . $item['mobile_phone'] . '-' . 'S';
        }, $validRows);

        $data = [
            'totalSmsInBatch' => count($validRows),
            'accountIds' => implode(',', $accountIds),
            'creditsUsed' => '',
            'successCount' => '',
            'failureCount' => '',
            'useCommonMessage' => $useCommonMessage,
            'commonMessage' => $request->input('common_message'),
            'xmlSent' => $sender->getXmlData(),
            'jsonReceived' => $sender->getRawResponse(),
        ];

        $sms->storeBatchStatus($data);

        d($validRows);
        dd($data);

        return \Redirect::back();
    }

    public function send()
    {
        // try {
        //     // Abhilash G (X-A) (8801933344)
        //     // Anurag G (X-A) (9603384881)
        //     $message = 'This is a test sms message';
        //     $messages = [
        //         ['number' => 8801933344, 'text' => 'Test sms message #1'],
        //         ['number' => 9603384881, 'text' => 'Test sms message #2'],
        //     ];

        //     $test = true;
        //     $sender = SmsSender::send($messages, $test);

        //     d($sender->getXmlData());
        //     d($sender->getRawResponse());
        //     dd($sender->getResult());

        // } catch (\Exception $e) {
        //     dd($e);
        // }

        // dd('---');
    }

}
