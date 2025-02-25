@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
<img src="{{ config('resource.url'). '/images/logos/logo_mail.png'}}" class="logo_header" alt="fisicalcoach" style="width: 300px;">
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
@lang('Follow us')

<?php
    $social_networks = config('social-network.social_networks');
?>

@foreach ($social_networks as $social)
  @if(config('social-network.' . $social . '.show'))<a href="{{ config('social-network.' . $social . '.url') }}" rel="{{ $social }}">![social]({{ config('resource.url'). '/images/social_networks/' . $social . '.png'}})</a>@endif
@endforeach

<br>
{{ $footer }}
<br>
<a href="https://fisicalcoach.com/politica-privacidad">Política de privacidad</a> - <a href="https://fisicalcoach.com/aviso-legal">Aviso Legal</a><br>
{{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
