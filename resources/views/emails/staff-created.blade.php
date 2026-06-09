<x-mail::message>
# Welcome to Genesis Goodhope Population Health!

Dear {{ $user->name }},

An administrator has created a new staff account for you on the Genesis Goodhope Population Health system.

Here are your one-time login credentials:

- **Email Address:** {{ $user->email }}
- **One-Time Password:** `{{ $password }}`
- **System Role:** {{ ucfirst($user->role) }}

Please use the button below to log in to your account. For security reasons, we strongly recommend changing your password immediately after your first login via your profile settings.

<x-mail::button :url="route('login')">
Log In to Dashboard
</x-mail::button>

If you have any questions or did not expect this email, please contact the system administrator.

Best regards,  
**Genesis Goodhope Population Health**  
Harare, Zimbabwe
</x-mail::message>
