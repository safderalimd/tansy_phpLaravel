<?php

namespace App\Http\Modules\thirdparty\sms;

use Exception;

class SmsSender
{
    private $username;

    private $hash;

    private $senderId;

    private $messages;

    private $test;

    private $rawResponse;

    private $xmlData;

    public function __construct($username, $hash, $senderId, $messages, $test)
    {
        $this->username = trim($username);
        $this->hash     = trim($hash);
        $this->senderId = trim($senderId);

        $this->messages = $messages;
        $this->test = intval($test);

        if (empty($this->senderId)) {
            $this->senderId = 'TXTLCL';
        }
    }

    public static function sandbox($username, $hash, $senderId, $messages)
    {
        return static::send($username, $hash, $senderId, $messages, true);
    }

    public static function send($username, $hash, $senderId, $messages, $test = false)
    {
        $sender = new static($username, $hash, $senderId, $messages, $test);
        return $sender->sendBulkSms();
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
}
