<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    public function sendMessage($data){

        // Your Account SId and Auth Token from twilio.com/console
        $sid = config('services.twilio.sid');
        $token= config('services.twilio.token');
        
        $client = new Client($sid, $token);        

        // Use the client to do fun stuff like send text messages
        $client->messages->create(
            // the number you'd like to send the message to,
            $data->phone,
            [
                // A twilio phone number you purchased 
                'from' => config('services.twilio.from'),
                // the body of tehe text message you'd like to send
                'body' => 'Hey ! This is test sms'. $data->code.'.' 
            ]
        );
    }
}