<?php

namespace App\Services;

use Twilio\Rest\Client;

class SmsVerifications
{

    private $sid;
    private $token;
    private $phone;
    private $vaerificationCode;

    public function __construct($phone, $vc)
    {
        $this->phone = $phone;
        $this->sid = env('TWILIO_SID');
        $this->token = env('TWILIO_TOKEN');
        $this->vaerificationCode = $vc;
        self::sendSmsVerify();
    }

    public function sendSmsVerify()
    {
        $client = new Client($this->sid, $this->token);
        $message = $client->messages->create(
            $this->phone,
            [
                'from' => '+14157993518',
                'body' => "Your verification code :" . $this->vaerificationCode
            ]
        );

        return $message;
    }
}
