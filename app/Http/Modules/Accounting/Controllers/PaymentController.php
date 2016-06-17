<?php

namespace App\Http\Modules\Accounting\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Accounting\Models\Payment;
use App\Http\Modules\Accounting\Requests\PaymentFormRequest;
use App\Http\Modules\thirdparty\sms\Models\SendSmsModel;
use App\Http\Modules\thirdparty\sms\SmsSender;

class PaymentController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . Payment::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rowType = $request->input('rt');
        $accountKey = $request->input('ak');
        $payment = Payment::summary($rowType, $accountKey);
        return view('modules.accounting.Payment.list', compact('payment', 'accountKey', 'rowType'));
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
        $rowType = $request->input('rt');
        $accountKey = $request->input('ak');
        $payment = new Payment($request->input());

        // todo: ask client what php validations to be made for payment

        $payment->payNow();
        $this->sendSms($payment);
        flash('Amount Paid!');
        return redirect("/cabinet/payment?ak={$accountKey}&rt={$rowType}");
    }

    // todo: refactor this
    public function sendSms($payment)
    {
        // send receipt sms if checkbox is on
        if (!isset($payment->send_receipt_sms)) {
            return false;
        }

        // get phone number
        $paymentDetail = Payment::details($payment->pk);
        $rows = $paymentDetail->rows();
        $phone = null;
        $accountEntityId = null;
        if (isset($rows[0]['mobile_phone'])) {
            $phone = $rows[0]['mobile_phone'];
        }
        if (isset($rows[0]['account_entity_id'])) {
            $accountEntityId = $rows[0]['account_entity_id'];
        }
        if (empty($phone)) {
            return false;
        }

        $receiptHeader = $payment->repository->getReceiptHeader($payment->receipt_id);
        if (!isset($receiptHeader[0])) {
            return false;
        }
        $receiptHeader = $receiptHeader[0];

        $text = 'Received ' . $receiptHeader['paid_by_name'] . ' payment on '. style_date($receiptHeader['receipt_date']) .': Receipt #' . $receiptHeader['receipt_number'] . ', Paid Amount ' . amount($payment->total_paid_amount) . ', New Balance ' . amount($receiptHeader['new_balance']);

        $sms = new SendSmsModel;
        $sms->setAttribute('screen_id', $payment->getScreenId());
        $sms->setAttribute('sms_type_id', $payment->getReceiptSmsTypeID());
        $sms->setAttribute('sms_account_row_type', null);
        $sms->setAttribute('sms_account_entity_id', $accountEntityId);
        $sms->setAttribute('exam_entity_id', null);

        $api = $sms->smsCredentials();
        $sender = new SmsSender($api['username'], $api['hash'], $api['senderId']);

        $messages = [[
            'sms_text'   => $text,
            'api_status' => '',
            'account_entity_id' => $accountEntityId,
            'mobile_phone' => $phone,
        ]];

        try {
            $sender->send($messages);
        } catch (\Exception $e) {
            // todo: log exception
            return \Redirect::back()->withErrors([$e->getMessage()]);
        }

        // extract json rows into an array
        $jsonRows = json_decode($sender->getRawResponse());

        // init total sms in batch, credits used, success count, failure count
        $totalSmsInBatch = 1;
        $creditsUsed  = 0;
        $successCount = 0;
        $failureCount = 0;

        $jsonRow = $jsonRows[0];
        $status = isset($jsonRow->status) ? $jsonRow->status : 'failure';
        if ($status == 'success') {
            $successCount++;
        } else {
            $failureCount++;
        }
        $creditsUsed += isset($jsonRow->cost) ? intval($jsonRow->cost) : 0;

        $messages[0]['api_status'] = $status;

        $accountIds = $messages[0]['account_entity_id'] . '-' . $messages[0]['mobile_phone'] . '-' . $messages[0]['api_status'];

        $data = [
            'screen_id' => $payment->getScreenId(),
            'totalSmsInBatch' => $totalSmsInBatch,
            'accountIds' => $accountIds,
            'creditsUsed' => $creditsUsed,
            'successCount' => $successCount,
            'failureCount' => $failureCount,
            'useCommonMessage' => true,
            'commonMessage' => $text,
            'xmlSent' => $sender->getXmlData(),
            'jsonReceived' => $sender->getRawResponse(),
            'balanceCount' => $sender->getBalance(),
        ];

        $sms->storeBatchStatus($data);
    }
}
