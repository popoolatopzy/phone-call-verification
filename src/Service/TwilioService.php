<?php
namespace App\Service;
use Twilio\Rest\Client;

class TwilioService
{
    public function sendVoiceOTP($recipientPhoneNumber, $otpCode)
    {
        $accountSid = env('TWILIO_ACCOUNT_SID');
        $authToken = env('TWILIO_AUTH_TOKEN');
        $twilioPhoneNumber = env('TWILIO_PHONE_NUMBER');
        $client = new Client($accountSid, $authToken);
        $call = $client->calls->create(
            $recipientPhoneNumber,
            $twilioPhoneNumber, 
            [
                'twiml' => '<Response><Say>Your OTP code is ' . $otpCode . '. Once again, your OTP code is ' . $otpCode . '.</Say></Response>'
            ]
        );
        return $call->sid;
    }
}