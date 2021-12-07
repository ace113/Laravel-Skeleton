@component('mail::message')
# Just One More Step

Hi, {{$user->first_name}}

Click the button below to activate you {{ config('app.name') }} account.
    

@component('mail::button', ['url' => $url, 'color' => 'success']) 
Activate Now 
@endcomponent
If yout didn't register for {{ config('app.name') }} account using this email address, you can safely ignore this
message. If you want to report abuse of your email address, please contact us.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
