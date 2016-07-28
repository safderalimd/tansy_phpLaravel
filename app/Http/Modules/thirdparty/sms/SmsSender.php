<?php

namespace App\Http\Modules\thirdparty\sms;

use Exception;

class SmsSender
{
    private $username;

    private $hash;

    private $senderId;

    private $messages;

    /**
     * Set to 1 for test/sandbox mode, 0 for real sms mode
     *
     * @var integer
     */
    private $test = 0;

    private $rawResponse;

    private $xmlData;

    public function __construct($username, $hash, $senderId)
    {
        $this->username = trim($username);
        $this->hash     = trim($hash);
        $this->senderId = trim($senderId);

        if (empty($this->senderId)) {
            $this->senderId = 'TXTLCL';
        }
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

        if (isset($_GET['test'])) {
            d($rawResponse);
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
