@component('mail::message')
# Hello,

Please change your password by clicking the button below.

@component('mail::button', ['url' => $url])
Change Password
@endcomponent

If you did not request a password reset, no further action is required.

<p>Best regards,<br>PULSE.freelancer Team</p>
@endcomponent
