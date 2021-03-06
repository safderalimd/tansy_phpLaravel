<?php

namespace App\Http\SMS\TextLocal;

use Exception;
use Session;
use App\Http\SMS\Exceptions\NoCredentialsException;
use App\Http\Modules\thirdparty\sms\Models\SendSmsModel;

class ProviderTextlocal
{
    private $prefixToParents = '';

    private $prefixToLoginUsers = '';

    private $prefixToLeads = '';

    private $prefixToEmployees = '';

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
        $this->test = env('SMS_SANDBOX', 0);

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

                } elseif ($prefix['prefix_type'] == 'To Leads') {
                    $this->prefixToLeads = $prefix['prefix_text'] . ' ';

                } elseif ($prefix['prefix_type'] == 'To Employees') {
                    $this->prefixToEmployees = $prefix['prefix_text'] . ' ';
                }
            }
        }
    }

    public function trim($prefix, $message, $maxLength = 301)
    {
        if (strlen($message) > $maxLength) {
            $message = substr($message, 0, $maxLength);
        }

        return $prefix . $message;
    }

    public function forgotPasswordOTP($phone, $message)
    {
        $messages = [[
            'sms_text'          => $this->trim($this->prefixToLoginUsers, $message),
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
            'sms_text'          => $this->trim($this->prefixToLoginUsers, $message),
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
            'sms_text'          => $this->trim($this->prefixToLoginUsers, $message),
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
            'sms_text'          => $this->trim($this->prefixToLoginUsers, $message),
            'mobile_phone'      => $phone,
            'account_entity_id' => Session::get('user.userID'),
        ]];

        $this->send($messages);
        $this->model->setSmsTypeIdLoginSMS();
        $this->logOneSMS();
    }

    public function paymentReceipt($phone, $message, $accoutId, $typeId, $screenId)
    {
        $messages = [[
            'sms_text'          => $this->trim($this->prefixToParents, $message),
            'mobile_phone'      => $phone,
            'account_entity_id' => $accoutId,
        ]];

        $this->model->setAttribute('screen_id', $screenId);
        $this->model->setAttribute('sms_type_id', $typeId);
        $this->send($messages);
        $this->logOneSMS();
    }

    public function sendMessages($messages, $model)
    {
        $trimLength = 145;
        if (isset($model->trimLength) && is_numeric($model->trimLength)) {
            $trimLength = $model->trimLength;
        }

        if ($model->prefixType == 'All Leads') {
            $prefixType = $this->prefixToLeads;

        } elseif ($model->prefixType == 'All Employees') {
            $prefixType = $this->prefixToEmployees;

        } else {
            $prefixType = $this->prefixToParents;
        }

        foreach ($messages as &$message) {
            $message['sms_text'] = $this->trim($prefixType, $message['sms_text'], $trimLength);
        }
        unset($message);
        $model->setAttribute('provider_entity_id', $this->providerId);
        $model->setAttribute('route_type_id', $this->routeTypeId);
        $this->send($messages);
        return $this;
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
            $messageText = $messages[0]['sms_text'];

            $this->model->setAttribute('provider_entity_id', $this->providerId);
            $this->model->setAttribute('route_type_id', $this->routeTypeId);
            $this->model->setAttribute('provider_batch_credits', $creditsUsed);
            $this->model->setAttribute('total_sms_in_batch', $totalSmsInBatch);
            $this->model->setAttribute('success_count', $successCount);
            $this->model->setAttribute('failure_count', $failureCount);
            $this->model->setAttribute('common_message', $messageText);
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

        return isset($result->balance->sms) ? $result->balance->sms : 0;
    }
}
