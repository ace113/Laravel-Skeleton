<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    public function sendMessage($data){

        // Your Account SId and Auth Token from twilio.com/console
        $sid = config('app.twilio_sid');
        $token= config('app.twilio_auth_token');
        
        $client = new Client($sid, $token);

        

        // Use the client to do fun stuff like send text messages
        $client->messages->create(
            // the number you'd like to send the message to,
            '+9779841760946',
            [
                // A twilio phone number you purchased 
                'from' => config('app.twilio_from_number'),
                // the body of tehe text message you'd like to send
                'body' => 'Hey ! This is test sms'. $data->code.'.' 
            ]
        );
    }
}