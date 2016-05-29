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

    public function getXmlData()
    {
        return $this->xmlData;
    }

    /**
     * Return an array of many JSON objects
     *
     * @see  http://ryanuber.com/07-31-2012/split-and-decode-json-php.html
     *
     * In some applications (such as PHPUnit, or salt), JSON output is presented as multiple
     * objects, which you cannot simply pass in to json_decode(). This function will split
     * the JSON objects apart and return them as an array of strings, one object per indice.
     *
     * @param string $json  The JSON data to parse
     *
     * @return array
     */
    public static function jsonSplitObjects($json)
    {
        $q = FALSE;
        $len = strlen($json);
        for($l=$c=$i=0;$i<$len;$i++)
        {
            $json[$i] == '"' && ($i>0?$json[$i-1]:'') != '\\' && $q = !$q;
            if(!$q && in_array($json[$i], array(" ", "\r", "\n", "\t"))){continue;}
            in_array($json[$i], array('{', '[')) && !$q && $l++;
            in_array($json[$i], array('}', ']')) && !$q && $l--;
            (isset($objects[$c]) && $objects[$c] .= $json[$i]) || $objects[$c] = $json[$i];
            $c += ($l == 0);
        }
        return $objects;
    }
}
