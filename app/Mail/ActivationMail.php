<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActivationMail extends Mailable
{
    use Queueable, SerializesModels;
    
    protected $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {      
        $verificationUrl = $this->verificationUrl($this->user);       
        return $this->markdown('emails.email') ->with(['url' => url($verificationUrl),
        'user' => $this->user]);
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        $hash = $notifiable->email_verify_token;
        $id = $notifiable->getKey();
        $expires = Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60));

        $params = [
            'expires' => $expires->getTimestamp(),
            'id' => $id,
            'hash' => $hash
        ];
        ksort($params);

        $url = URL::route(
            'api.verify.email',
            $params,
            true
        );


        $key = config('app.key');
        $signature = hash_hmac('sha256', $url , $key);

        $params['signature'] = $signature;

        return URL::route('verify.email', $params, true);

        // return URL::temporarySignedRoute(
        //     'verify.email',
        //     Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
        //     [
        //         'id' => $notifiable->getKey(),
        //         'hash' => $notifiable->email_verify_token,
        //     ]
        // );
        
    }
}
