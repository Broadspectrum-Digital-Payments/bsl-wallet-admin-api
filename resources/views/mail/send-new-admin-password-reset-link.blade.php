<x-mail::message>
# Hello {{ $name }},

You are receiving this email because an account was created for you.
Click the link to reset your password to enable you login.

<x-mail::button :url="$link">
Reset Password
</x-mail::button>

If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser: {{ $link }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
