@component('mail::layout')
@slot('header')
@component('mail::header', ['url' => config('app.url')])
<img src="{{ asset('img/logo_dark_text.png') }}">
@endcomponent
@endslot

Welcome to {{ config('app.name') }},

here are your account login credentials:

@component('mail::panel')
**Email:** {{ $user->email }}

**Password:** {{ $password }}
@endcomponent

You can also login by clicking on <a href="{{route('login.link', $user->login_hash)}}" target="_blank">this link</a>.

Thanks,
{{ config('app.name') }}

@slot('footer')
@component('mail::footer')
© {{ now()->year }} {{ config('app.name') }} | All rights reserved
@endcomponent
@endslot

@endcomponent
