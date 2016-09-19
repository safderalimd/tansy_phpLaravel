<?php

namespace App\Http\SMS\Providers;

use Exception;
use App\Http\SMS\Providers\Provider;
use App\Http\SMS\Exceptions\NoCredentialsException;
use App\Http\Modules\thirdparty\sms\Models\SendSmsModel;

class ProviderTextlocal extends Provider
{
    private $username;

    private $hash;

    private $senderId;

    private $messages;

    private $messagePrefix = '';

    /**
     * Set to 1 for test/sandbox mode, 0 for real sms mode
     *
     * @var integer
     */
    private $test = 1;

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

        $this->checkNotEmptyCredentials();

        $this->setSenderId();
        $this->setMessagePrefix();
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

    public function setMessagePrefix()
    {
        $this->messagePrefix = $this->model->textlocalMessagePrefix();
    }

    public function sendOneMessage($phone, $message)
    {

    }

    public function send($messages)
    {
        $this->messages = $messages;
        return $this->sendBulkSms();
    }

    public function sendBulkSms()
    {
        $this->generateXmlData();

        $post = 'data='. urlencode($this->xmlData);
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

        return $this;
    }

    protected function generateXmlData()
    {
        $view = view('thirdparty.sms.SendSms.sms-bulk-api-call', [
            'username' => $this->username,
            'hash'     => $this->hash,
            'senderId' => $this->senderId,
            'test'     => $this->test,
            'messages' => $this->messages,
            'prefix'   => $this->messagePrefix . ' ',
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
