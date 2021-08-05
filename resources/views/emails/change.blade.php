@component('mail::message')
    Dear {{ $user->firstname }}

    Press the button bellow if you wish to change your current email-address
    @component('mail::button', ['url' => route('verify_email', ['id' => $user->id, 'token' => $token, 'email' => $email])])
        Change Email
    @endcomponent

    Is this email not directed to you or do you not wish to change your email? Than you may ignore this.

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
