<?php

namespace App\Http\Modules\thirdparty\sms;

use Exception;

class SmsSender
{
    private $username;

    private $password;

    private $messages;

    private $test;

    private $rawResponse;

    private $result;

    private $xmlData;

    public function __construct($messages, $test)
    {
        $this->test = intval($test);
        $this->messages = $messages;
        $this->username = 'safderalimd@outlook.com';
        $this->password = 'Abil@usuf1';
    }

    public static function sandbox($messages)
    {
        return static::send($messages, true);
    }

    public static function send($messages, $test = false)
    {
        $sender = new static($messages, $test);
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

        $this->result = $result;

        return $this;
    }

    protected function generateXmlData()
    {
        $view = view('thirdparty.sms.SendSms.sms-bulk-api-call', [
            'username' => $this->username,
            'password' => $this->password,
            'test'     => $this->test,
            'messages' => $this->messages,
        ]);

        $this->xmlData = $view->render();
    }

    public function getRawResponse()
    {
        return $this->rawResponse;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function getXmlData()
    {
        return $this->xmlData;
    }
}
