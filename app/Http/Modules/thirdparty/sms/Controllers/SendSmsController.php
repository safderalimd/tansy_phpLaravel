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
        // dd($sms->rows());
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

        // get only rows selected
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
            $row['api_status'] = '';
            return $row;
        }, $validRows);

        // send the sms messages
        try {
            $sender = SmsSender::send($validRows);
        } catch (\Exception $e) {
            return \Redirect::back()->withErrors([$e->getMessage()]);
        }

        // extract combined json rows into an array
        $jsonRows = SmsSender::jsonSplitObjects($sender->getRawResponse());
        $accountIds = [];

        // init total sms in batch, credits used, success count, failure count
        $totalSmsInBatch = count($validRows);
        $creditsUsed = 0;
        $successCount = 0;
        $failureCount = 0;

        // calculate credits used, success count, failure count
        foreach ($jsonRows as $jsonRow) {
            $decoded = json_decode($jsonRow);
            $status = isset($decoded->status) ? $decoded->status : 'failure';
            if ($status == 'success') {
                $successCount++;
            } else {
                $failureCount++;
            }
            $creditsUsed += isset($decoded->cost) ? intval($decoded->cost) : 0;

            // set the statuses on the valid rows array
            if (isset($decoded->custom)) {
                foreach ($validRows as &$validRow) {
                    if ($validRow['account_entity_id'] == $decoded->custom) {
                        $validRow['api_status'] = $status;
                        break;
                    }
                }
                unset($validRow); // clear reference

            } elseif (isset($decoded->warnings[0]->numbers) && is_string($decoded->warnings[0]->numbers)) {
                $number = $decoded->warnings[0]->numbers;
                foreach ($validRows as &$validRow) {
                    if (strpos($number, $validRow['mobile_phone']) !== false) {
                        $validRow['api_status'] = $status;
                        break;
                    }
                }
                unset($validRow); // clear reference

            } elseif (isset($decoded->messages[0]->recipients) && is_string($decoded->messages[0]->recipients)) {
                $number = $decoded->messages[0]->recipients;
                foreach ($validRows as &$validRow) {
                    if (strpos($number, $validRow['mobile_phone']) !== false) {
                        $validRow['api_status'] = $status;
                        break;
                    }
                }
                unset($validRow); // clear reference
            }
        }

        $accountIds = array_map(function($item) {
            return $item['account_entity_id'] . '-' . $item['mobile_phone'] . '-' . $item['api_status'];
        }, $validRows);

        $data = [
            'totalSmsInBatch' => $totalSmsInBatch,
            'accountIds' => implode(',', $accountIds),
            'creditsUsed' => $creditsUsed,
            'successCount' => $successCount,
            'failureCount' => $failureCount,
            'useCommonMessage' => $useCommonMessage,
            'commonMessage' => $request->input('common_message'),
            'xmlSent' => $sender->getXmlData(),
            'jsonReceived' => $sender->getRawResponse(),
        ];

        $sms->storeBatchStatus($data);

        d($validRows);
        d($data);

        // return \Redirect::back();
    }
}
