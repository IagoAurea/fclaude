@component('mail::message')
{{-- Greeting --}}
@if(!empty($greeting))
  <div style="text-align: center">
    <h1>{{ $greeting }}</h1>
  </div>
@else
  @if($level === 'error')
    @lang('Whoops!')
  @else
    @lang('Hello!')
  @endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
  {{ $line }}
@endforeach

{{-- Action Button --}}
@isset($actionText)
  @component('mail::button', ['url' => $actionUrl, 'color' => $color])
    {{ $actionText }}
  @endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
  {{ $line }}
@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
  {{ $salutation }}
@else
  @lang('Regards')<br>
  El equipo de fisicalcoach®
@endif

{{-- Subcopy --}}
@isset($actionText)
  @slot('subcopy')
  @lang(
    "If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
      'actionText' => $actionText,
    ]
  ) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
  @endslot
@endisset

@slot('footer')
  @if(!empty($footer))
   {{ $footer }}
  @endif
@endslot
@endcomponent
