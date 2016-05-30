<?php

namespace App\Http\Modules\thirdparty\sms\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\thirdparty\sms\Models\SendSmsGeneral;
use App\Http\Modules\thirdparty\sms\Models\SendSmsExam;
use App\Http\Modules\thirdparty\sms\Models\SendSmsAttendance;
use App\Http\Modules\thirdparty\sms\Models\SendSmsFeeDue;
use App\Http\Modules\thirdparty\sms\Models\SendSmsModel;
use App\Http\Modules\thirdparty\sms\SmsSender;

class SendSmsController extends Controller
{
    public function feeDue(Request $request)
    {
        $sms = new SendSmsFeeDue($request->input());
        return view('thirdparty.sms.SendSms.fee-due', compact('sms'));
    }

    public function attendence(Request $request)
    {
        $sms = new SendSmsAttendance($request->input());
        return view('thirdparty.sms.SendSms.attendance', compact('sms'));
    }

    public function examResults(Request $request)
    {
        $sms = new SendSmsExam($request->input());
        return view('thirdparty.sms.SendSms.exam-results', compact('sms'));
    }

    public function general(Request $request)
    {
        $sms = new SendSmsGeneral($request->input());
        return view('thirdparty.sms.SendSms.general', compact('sms'));
    }

    public function sendFeeDue(Request $request)
    {
        $this->validate($request, ['student_ids' => 'required|string']);
        $sms = new SendSmsFeeDue($request->input());
        return $this->sendSmsToStudents($sms, $request->input('student_ids'));
    }

    public function sendAttendence(Request $request)
    {
        $this->validate($request, ['student_ids' => 'required|string']);
        $this->validate($request, ['hidden_absense_date' => 'required|string|max:20']);
        $sms = new SendSmsAttendance($request->input());
        return $this->sendSmsToStudents($sms, $request->input('student_ids'));
    }

    public function sendExamResults(Request $request)
    {
        $this->validate($request, ['student_ids' => 'required|string']);
        $sms = new SendSmsExam($request->input());
        return $this->sendSmsToStudents($sms, $request->input('student_ids'));
    }

    public function sendGeneral(Request $request)
    {
        $this->validate($request, ['student_ids' => 'required|string']);
        $this->validate($request, ['common_message' => 'required|string|max:160']);
        $sms = new SendSmsGeneral($request->input());

        $text = $request->input('common_message');
        return $this->sendSmsToStudents($sms, $request->input('student_ids'), true, $text);
    }

    public function sendSmsToStudents(SendSmsModel $sms, $ids, $commonMessage = false, $text = '')
    {
        $sms->setSmsBatchAttributes();

        // get rows from db with all students
        $dbRows = $sms->rows();

        // get only rows selected
        $ids = explode(',', $ids);
        $validRows = array_filter($dbRows, function($row) use ($ids) {
            return in_array($row['account_entity_id'], $ids);
        });

        // validate that valid row count is less than balance
        if (!is_numeric($sms->smsBalanceCount)) {
            $sms->smsBalanceCount = 0;
        }
        if (count($validRows) > $sms->smsBalanceCount) {
            throw new \Exception("You do not have enought sms credits.");
        }

        // apply the message to the rows
        $validRows = array_map(function($row) use ($commonMessage, $text) {
            if ($commonMessage) {
                $row['sms_text'] = $text;
            } elseif (isset($row['due_amount'])) {
                $row['sms_text'] = 'Your current fee due amount is ' . amount($row['due_amount']);
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

        // init total sms in batch, credits used, success count, failure count
        $totalSmsInBatch = count($validRows);
        $creditsUsed  = 0;
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
            'useCommonMessage' => $commonMessage,
            'commonMessage' => $text,
            'xmlSent' => $sender->getXmlData(),
            'jsonReceived' => $sender->getRawResponse(),
        ];

        $sms->storeBatchStatus($data);

        // d($sms);
        // d($validRows);
        // dd($data);

        return \Redirect::back();
    }
}
