<?php

namespace App\Http\Modules\thirdparty\sms\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\thirdparty\sms\Models\SendSmsGeneral;
use App\Http\Modules\thirdparty\sms\Models\SendSmsGeneralV2;
use App\Http\Modules\thirdparty\sms\Models\SendSmsExam;
use App\Http\Modules\thirdparty\sms\Models\SendSmsExamSchedule;
use App\Http\Modules\thirdparty\sms\Models\SendSmsAttendance;
use App\Http\Modules\thirdparty\sms\Models\SendSmsFeeDue;
use App\Http\Modules\thirdparty\sms\Models\SendSmsModel;
use App\Http\Modules\thirdparty\sms\SmsSender;
use App\Http\Models\Grid;
use Exception;

class SendSmsController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . SendSmsGeneral::staticScreenId(), ['only' => [
            'general',
            'sendGeneral',
        ]]);

        $this->middleware('screen:' . SendSmsGeneralV2::staticScreenId(), ['only' => [
            'generalV2',
            'sendGeneralV2',
        ]]);

        $this->middleware('screen:' . SendSmsExam::staticScreenId(), ['only' => [
            'examResults',
            'sendExamResults',
        ]]);

        $this->middleware('screen:' . SendSmsExamSchedule::staticScreenId(), ['only' => [
            'examSchedule',
            'sendExamSchedule',
        ]]);

        $this->middleware('screen:' . SendSmsAttendance::staticScreenId(), ['only' => [
            'attendence',
            'sendAttendance',
        ]]);

        $this->middleware('screen:' . SendSmsFeeDue::staticScreenId(), ['only' => [
            'feeDue',
            'sendFeeDue',
        ]]);
    }

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

    public function examSchedule(Request $request)
    {
        $sms = new SendSmsExamSchedule($request->input());
        return view('thirdparty.sms.SendSms.exam-schedule', compact('sms'));
    }

    public function general(Request $request)
    {
        $grid = new Grid('/' . $request->path());
        $grid->setAttribute('input_value_filter2', $request->input('aei'));
        $grid->setAttribute('input_value_filter1', $request->input('art'));
        $grid->fill($request->input());
        $grid->loadData();

        if (is_null($request->input('aei')) || is_null($request->input('art')) || is_null($request->input('sti'))) {
            $grid->emptyRows();
        }

        $sms = new SendSmsGeneral($request->input());

        $options = [
            'beforeGridInclude'  => 'thirdparty.sms.SendSms.GeneralV1.before-grid-include',
            'headerFirstInclude' => 'thirdparty.sms.SendSms.GeneralV1.header-first-include',
            'rowFirstInclude'    => 'thirdparty.sms.SendSms.GeneralV1.row-first-include',
            'afterGridInclude'   => 'thirdparty.sms.SendSms.GeneralV1.after-grid-include',
            'scriptsInclude'     => 'thirdparty.sms.SendSms.GeneralV1.scripts-include',
            'datatableOff'       => true,
        ];

        return view('grid.list', compact('grid', 'options', 'sms'));
    }

    public function generalV2(Request $request)
    {
        $grid = new Grid('/' . $request->path());
        $grid->setAttribute('input_value_filter2', $request->input('aei'));
        $grid->setAttribute('input_value_filter1', $request->input('art'));
        $grid->fill($request->input());
        $grid->loadData();

        if (is_null($request->input('aei')) || is_null($request->input('art')) || is_null($request->input('sti'))) {
            $grid->emptyRows();
        }

        $sms = new SendSmsGeneralV2($request->input());

        $options = [
            'beforeGridInclude'  => 'thirdparty.sms.SendSms.GeneralV2.before-grid-include',
            'headerFirstInclude' => 'thirdparty.sms.SendSms.GeneralV2.header-first-include',
            'headerLastInclude'  => 'thirdparty.sms.SendSms.GeneralV2.header-last-include',
            'rowFirstInclude'    => 'thirdparty.sms.SendSms.GeneralV2.row-first-include',
            'rowLastInclude'     => 'thirdparty.sms.SendSms.GeneralV2.row-last-include',
            'afterGridInclude'   => 'thirdparty.sms.SendSms.GeneralV2.after-grid-include',
            'scriptsInclude'     => 'thirdparty.sms.SendSms.GeneralV2.scripts-include',
            'datatableOff'       => true,
        ];

        return view('grid.list', compact('grid', 'options', 'sms'));
    }

    public function sendFeeDue(Request $request)
    {
        $this->validate($request, ['student_ids' => 'required|string']);
        $sms = new SendSmsFeeDue($request->input());
        flash('Fee Due SMS Sent!');
        return $this->sendSmsToStudents($sms, $request->input('student_ids'));
    }

    public function sendAttendance(Request $request)
    {
        $this->validate($request, ['student_ids' => 'required|string']);
        $this->validate($request, ['hidden_absense_date' => 'required|string|max:20']);
        $sms = new SendSmsAttendance($request->input());
        flash('Attendance SMS Sent!');
        return $this->sendSmsToStudents($sms, $request->input('student_ids'));
    }

    public function sendExamResults(Request $request)
    {
        $this->validate($request, ['student_ids' => 'required|string']);
        $sms = new SendSmsExam($request->input());
        flash('Exam Results SMS Sent!');
        return $this->sendSmsToStudents($sms, $request->input('student_ids'));
    }

    public function sendExamSchedule(Request $request)
    {
        $this->validate($request, ['student_ids' => 'required|string']);
        $sms = new SendSmsExamSchedule($request->input());
        flash('Exam Schedule SMS Sent!');
        return $this->sendSmsToStudents($sms, $request->input('student_ids'));
    }

    public function sendGeneral(Request $request)
    {
        $this->validate($request, ['student_ids' => 'required|string']);
        $this->validate($request, ['common_message' => 'required|string|max:160']);

        $grid = new Grid('/' . $request->path());
        $grid->setAttribute('input_value_filter2', $request->input('aei'));
        $grid->setAttribute('input_value_filter1', $request->input('art'));
        $grid->fill($request->input());
        $grid->loadData();

        $sms = new SendSmsGeneral($request->input());
        $dbRows = $grid->rows();
        $ids = $request->input('student_ids');
        $ids = explode(',', $ids);
        $text = $request->input('common_message');

        // get only rows selected
        $validRows = array_filter($dbRows, function($row) use ($ids) {
            return in_array($row['account_entity_id'], $ids);
        });

        // apply the message to the rows
        $validRows = array_map(function($row) use ($text) {
            $row['sms_text'] = $text;
            $row['api_status'] = '';
            return $row;
        }, $validRows);

        flash('General SMS Sent!');
        return $this->sendSmsToStudents($sms, $validRows, true, $text, true);
    }

    public function sendGeneralV2(Request $request)
    {
        $ids = [];
        $messages = json_decode($request->input('text_messages'));

        // validate message lenght
        foreach ($messages as $message) {
            $ids[] = $message->id;
            if (strlen($message->message) > 160) {
                throw new Exception("Message is too long. Max size is 160 chars.");
            }
        }

        $grid = new Grid('/' . $request->path());
        $grid->setAttribute('input_value_filter2', $request->input('aei'));
        $grid->setAttribute('input_value_filter1', $request->input('art'));
        $grid->fill($request->input());
        $grid->loadData();

        $sms = new SendSmsGeneralV2($request->input());
        $dbRows = $grid->rows();

        // get only rows selected
        $validRows = array_filter($dbRows, function($row) use ($ids) {
            return in_array($row['account_entity_id'], $ids);
        });

        // apply the message to the rows
        $validRows = array_map(function($row) use ($messages) {
            $row['sms_text'] = '';
            $row['api_status'] = '';
            foreach ($messages as $message) {
                if ($row['account_entity_id'] == $message->id) {
                    $row['sms_text'] = $message->message;
                    break;
                }
            }
            return $row;
        }, $validRows);

        flash('SMS Sent!');
        return $this->sendSmsToStudents($sms, $validRows, false, '', true);
    }

    protected function sendSmsToStudents(SendSmsModel $sms, $ids, $commonMessage = false, $text = '', $skipRows = false)
    {
        // clear the sms balance from the session
        session()->put('smsBalance', null);

        // get the textlocal.in credentials for this domain from the database
        $api = $sms->smsCredentials();

        // create sms sender object
        $sender = new SmsSender($api['username'], $api['hash'], $api['senderId']);
        $sender->setMessagePrefix($sms->smsMessagePrefix());

        // set request properties on the model
        $sms->setSmsBatchAttributes();

        if ($skipRows) {
            $validRows = $ids;
        } else {
            // get rows from db with all students
            $dbRows = $sms->rows();

            // get only rows selected
            $ids = explode(',', $ids);
            $validRows = array_filter($dbRows, function($row) use ($ids) {
                return in_array($row['account_entity_id'], $ids);
            });
        }

        // validate that valid row count is less than balance
        $smsBalanceCount = $sender->getBalance();
        if (!is_numeric($smsBalanceCount)) {
            $smsBalanceCount = 0;
        }

        if (count($validRows) > $smsBalanceCount) {
            throw new Exception("You do not have enought sms credits.");
        }

        if (! $skipRows) {
            // apply the message to the rows
            $validRows = array_map(function($row) use ($commonMessage, $text) {
                if ($commonMessage) {
                    $row['sms_text'] = $text;
                } elseif (isset($row['due_amount'])) {
                    $row['sms_text'] = $row['first_name'] . ': ' . 'Your current fee due amount is ' . amount($row['due_amount']);
                } else {
                    $row['sms_text'] = $row['first_name'] . ': ' . $row['sms_text'];
                }
                $row['api_status'] = '';
                return $row;
            }, $validRows);
        }

        // send the sms messages
        try {
            $sender->send($validRows);
        } catch (Exception $e) {
            // todo: log exception
            return \Redirect::back()->withErrors([$e->getMessage()]);
        }

        // extract json rows into an array
        $jsonRows = json_decode($sender->getRawResponse());

        // init total sms in batch, credits used, success count, failure count
        $totalSmsInBatch = count($validRows);
        $creditsUsed  = 0;
        $successCount = 0;
        $failureCount = 0;

        // calculate credits used, success count, failure count
        foreach ($jsonRows as $jsonRow) {
            $status = isset($jsonRow->status) ? $jsonRow->status : 'failure';
            if ($status == 'success') {
                $successCount++;
            } else {
                $failureCount++;
            }
            $creditsUsed += isset($jsonRow->cost) ? intval($jsonRow->cost) : 0;

            // set the statuses on the valid rows array
            if (isset($jsonRow->custom)) {
                foreach ($validRows as &$validRow) {
                    if ($validRow['account_entity_id'] == $jsonRow->custom) {
                        $validRow['api_status'] = $status;
                        break;
                    }
                }
                unset($validRow); // clear reference

            } elseif (isset($jsonRow->warnings[0]->numbers) && is_string($jsonRow->warnings[0]->numbers)) {
                $number = $jsonRow->warnings[0]->numbers;
                foreach ($validRows as &$validRow) {
                    if (strpos($number, $validRow['mobile_phone']) !== false) {
                        $validRow['api_status'] = $status;
                        break;
                    }
                }
                unset($validRow); // clear reference

            } elseif (isset($jsonRow->messages[0]->recipients) && is_string($jsonRow->messages[0]->recipients)) {
                $number = $jsonRow->messages[0]->recipients;
                foreach ($validRows as &$validRow) {
                    if (strpos($number, $validRow['mobile_phone']) !== false) {
                        $validRow['api_status'] = $status;
                        break;
                    }
                }
                unset($validRow); // clear reference
            }
        }

        if ($skipRows) {
            $accountIds = array_map(function($item) {
                $text = $item['sms_text'];
                $text = str_replace(',', ' ', $text);
                $text = str_replace('|', ' ', $text);
                if (strlen($text) == 0) {
                    $text = '-';
                }
                if (empty($item['api_status'])) {
                    $item['api_status'] = 'failure';
                }
                return $item['account_entity_id'].'|'.$item['mobile_phone'].'|'.$item['api_status'].'|'.$text;
            }, $validRows);
        } else {
            $accountIds = array_map(function($item) {
                if (empty($item['api_status'])) {
                    $item['api_status'] = 'failure';
                }
                return $item['account_entity_id'] . '-' . $item['mobile_phone'] . '-' . $item['api_status'];
            }, $validRows);
        }

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
            'balanceCount' => $sender->getBalance(),
        ];

        if ($skipRows) {
            $sms->storeBatchStatusV2($data);
        } else {
            $sms->storeBatchStatus($data);
        }

        return \Redirect::back();
    }
}
