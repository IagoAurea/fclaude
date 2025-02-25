@component('mail::message')
  {{-- Intro Lines --}}
  @foreach ($introLines as $line)
    {{ $line }}
  @endforeach

  @slot('footer')
    @lang('You received this email because you make part of the subscription plan via ownership or license').
  @endslot
@endcomponent
