<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Http\Modules\thirdparty\sms\Models\SendSmsModel;
use Exception;
use SMS;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function sendSmsToStudents(SendSmsModel $sms, $ids, $commonMessage = false, $text = '', $skipRows = false)
    {
        if ($sms->prefixType == 'All Leads') {
            $smsRoute = SMS::promotional();
        } else {
            $smsRoute = SMS::transactional();
        }

        if (! $smsRoute->isActive()) {
            return \Redirect::back();
        }

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

        // todo: not sure if i need this; textlocal will throw error if we don't have enoght credits
        // validate that valid row count is less than balance
        if (count($validRows) > $smsRoute->balance()) {
            return \Redirect::back()->withErrors(["You do not have enought sms credits."]);
        }

        if (! $skipRows) {
            // apply the message to the rows
            $validRows = array_map(function($row) use ($commonMessage, $text) {
                if ($commonMessage) {
                    $row['sms_text'] = $text;
                }
                $row['api_status'] = '';
                return $row;
            }, $validRows);
        }

        // send the sms messages
        try {
            $sender = $smsRoute->sendMessages($validRows, $sms);
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
        foreach ((array)$jsonRows as $jsonRow) {
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

        $sms->setAttribute('total_sms_in_batch', $totalSmsInBatch);
        $sms->setAttribute('entityID_smsMobile_PrvStatus_details',  implode(',', $accountIds));
        $sms->setAttribute('provider_batch_credits', $creditsUsed);
        $sms->setAttribute('success_count', $successCount);
        $sms->setAttribute('failure_count', $failureCount);
        $sms->setAttribute('common_message_flag', intval($commonMessage));
        $sms->setAttribute('common_message', $text);
        $sms->setAttribute('log_json_sms_sent', $sender->getXmlData());
        $sms->setAttribute('log_json_sms_received', $sender->getRawResponse());
        $sms->setAttribute('balance_count', $sender->getBalance());

        if ($skipRows) {
            $sms->logSMS_V2();
        } else {
            $sms->logSMS_V1();
        }

        return \Redirect::back();
    }
}
