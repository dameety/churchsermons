@component('mail::message')

@component('mail::panel', ['url' => ''])
##{{ $settings -> mailHeading }}
@endcomponent


Hello {{ $user->name }},

{{ $settings -> mailBody }}


Thanks,<br>
{{ config('app.name') }}
@endcomponent
