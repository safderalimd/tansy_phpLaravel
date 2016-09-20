<?php

namespace App\Http\SMS\Providers;

use Exception;
use Session;
use App\Http\SMS\Providers\Provider;
use App\Http\SMS\Exceptions\NoCredentialsException;
use App\Http\Modules\thirdparty\sms\Models\SendSmsModel;

class ProviderTextlocal extends Provider
{
    private $prefixToParents = '';

    private $prefixToLoginUsers = '';

    private $username;

    private $hash;

    private $senderId;

    private $providerId;

    private $routeTypeId;

    private $messages;

    private $messagePrefixes;

    /**
     * Set to 1 for test/sandbox mode, 0 for real sms mode
     *
     * @var integer
     */
    private $test = 0;

    private $rawResponse;

    private $xmlData;

    /**
     * @var SendSmsModel
     */
    protected $model;

    public function __construct(SendSmsModel $model, $credentials)
    {
        $this->model = $model;
        $this->username = isset($credentials['sender_user_name']) ? trim($credentials['sender_user_name']) : null;
        $this->hash     = isset($credentials['sender_hash']) ? trim($credentials['sender_hash']) : null;
        $this->senderId = isset($credentials['sender_id']) ? trim($credentials['sender_id']) : null;

        $this->providerId = isset($credentials['provider_entity_id']) ? trim($credentials['provider_entity_id']) : null;
        $this->routeTypeId = isset($credentials['route_type_id']) ? trim($credentials['route_type_id']) : null;

        $this->checkNotEmptyCredentials();

        $this->setSenderId();
        $this->setMessagePrefixes();
    }

    public function checkNotEmptyCredentials()
    {
        if (empty($this->username) || empty($this->hash)) {
            throw new NoCredentialsException("Credentials for SMS Provider are not set.");
        }
    }

    public function setSenderId()
    {
        if (empty($this->senderId)) {
            $this->senderId = 'TXTLCL';
        }
    }

    public function setMessagePrefixes()
    {
        $messagePrefixes = $this->model->textlocalMessagePrefixes();
        foreach ($messagePrefixes as $prefix) {
            if (isset($prefix['prefix_type'], $prefix['prefix_text'])) {
                if ($prefix['prefix_type'] == 'To Parents') {
                    $this->prefixToParents = $prefix['prefix_text'] . ' ';
                } elseif ($prefix['prefix_type'] == 'To Login Users') {
                    $this->prefixToLoginUsers = $prefix['prefix_text'] . ' ';
                }
            }
        }
    }

    public function trim($message)
    {
        if (strlen($message) > 145) {
            return substr($message, 0, 145);
        }

        return $message;
    }

    public function forgotPasswordOTP($phone, $message)
    {
        $messages = [[
            'sms_text'          => $this->trim($this->prefixToLoginUsers . $message),
            'mobile_phone'      => $phone,
            'account_entity_id' => Session::get('forgot_passwd.user_id'),
        ]];

        $this->send($messages);
        $this->model->setSmsTypeIdChangePassword();
        $this->logOneSMS();
    }

    public function changePassword($phone, $message)
    {
        $messages = [[
            'sms_text'          => $this->trim($this->prefixToLoginUsers . $message),
            'mobile_phone'      => $phone,
            'account_entity_id' => Session::get('user.userID'),
        ]];

        $this->send($messages);
        $this->model->setSmsTypeIdChangePassword();
        $this->logOneSMS();
    }

    public function loginOTP($phone, $message)
    {
        $messages = [[
            'sms_text'          => $this->trim($this->prefixToLoginUsers . $message),
            'mobile_phone'      => $phone,
            'account_entity_id' => Session::get('user.userID'),
        ]];

        $this->send($messages);
        $this->model->setSmsTypeIdLoginOTP();
        $this->logOneSMS();
    }

    public function loginSMS($phone, $message)
    {
        $messages = [[
            'sms_text'          => $this->trim($this->prefixToLoginUsers . $message),
            'mobile_phone'      => $phone,
            'account_entity_id' => Session::get('user.userID'),
        ]];

        $this->send($messages);
        $this->model->setSmsTypeIdLoginSMS();
        $this->logOneSMS();
    }

    public function sendGeneralSMS($messages)
    {
        foreach ($messages as &$message) {
            $message['sms_text'] = $this->trim($message['sms_text']);
        }
        unset($message);
        $this->send($messages);
        $this->logMultipleSMS();
    }

    public function send($messages)
    {
        $this->messages = $messages;
        $this->sendBulkSms();
    }

    public function logOneSMS()
    {
        try {
            $jsonRow = json_decode($this->getRawResponse());
            $jsonRow = isset($jsonRow[0]) ? $jsonRow[0] : null;

            $totalSmsInBatch = 1;
            $creditsUsed  = 0;
            $successCount = 0;
            $failureCount = 0;

            $status = isset($jsonRow->status) ? $jsonRow->status : 'failure';
            if ($status == 'success') {
                $successCount++;
            } else {
                $failureCount++;
            }

            $creditsUsed += isset($jsonRow->cost) ? intval($jsonRow->cost) : 0;
            $messages = $this->messages;
            $accountId = $messages[0]['account_entity_id'] . '-' . $messages[0]['mobile_phone'] . '-' . $status;

            $this->model->setAttribute('provider_entity_id', $this->providerId);
            $this->model->setAttribute('route_type_id', $this->routeTypeId);
            $this->model->setAttribute('provider_batch_credits', $creditsUsed);
            $this->model->setAttribute('total_sms_in_batch', $totalSmsInBatch);
            $this->model->setAttribute('success_count', $successCount);
            $this->model->setAttribute('failure_count', $failureCount);
            $this->model->setAttribute('common_message_flag', 0);
            $this->model->setAttribute('entityID_smsMobile_PrvStatus_details', $accountId);
            $this->model->setAttribute('log_json_sms_sent', $this->getXmlData());
            $this->model->setAttribute('log_json_sms_received', $this->getRawResponse());

            $this->model->setAttribute('balance_count', $this->getBalance());

            $this->model->logSMS_V1();

        } catch (Exception $e) {
            // todo: log exception
        }
    }

    public function sendBulkSms()
    {
        $this->generateXmlData();

        $post = 'data='. urlencode($this->getXmlData());
        $url = "http://api.textlocal.in/xmlapi.php";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $rawResponse = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($rawResponse === false) {
            throw new Exception('Failed to connect to the Textlocal service: ' . $error);
        } elseif ($httpCode != 200) {
            throw new Exception('Bad response from the Textlocal service: HTTP code ' . $httpCode);
        }

        $this->rawResponse = $rawResponse;
    }

    protected function generateXmlData()
    {
        $view = view('thirdparty.sms.SendSms.sms-bulk-api-call', [
            'username' => $this->username,
            'hash'     => $this->hash,
            'senderId' => $this->senderId,
            'test'     => $this->test,
            'messages' => $this->messages,
        ]);

        $this->xmlData = $view->render();
    }

    public function getRawResponse()
    {
        return $this->rawResponse;
    }

    public function getXmlData()
    {
        return $this->xmlData;
    }

    /**
     * Get Credit Balances
     * @return array
     */
    public function getBalance()
    {
        $url = 'http://api.textlocal.in/balance/';

        $params = [
            'username' => $this->username,
            'hash' => $this->hash,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $rawResponse = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($rawResponse === false) {
            throw new Exception('Failed to connect to the Textlocal service: ' . $error);
        } elseif ($httpCode != 200) {
            throw new Exception('Bad response from the Textlocal service: HTTP code ' . $httpCode);
        }

        $result = json_decode($rawResponse);
        if (isset($result->errors)) {
            if (count($result->errors) > 0) {
                foreach ($result->errors as $error) {
                    switch ($error->code) {
                        default:
                            throw new Exception($error->message);
                    }
                }
            }
        }

        return $result->balance->sms;
    }
}
