@component('mail::message')

<div style="text-align: center">
  <h1>@lang('Welcome')</h1>
</div>

@lang("You have been invited to make part of our community by joining the \":clubName\" club's members team", [
  'clubName' => $clubName,
])

<div style="text-align: center">
  <p>{{ $annotation }}</p>
</div>

<div>

<img src="{{ config('resource.url'). '/images/fi/splash_bottom.png'}}" alt="fi" width="40%">

<div class="btn-acept-send-invitation">
@component('mail::button', ['url' => $acceptUrl, 'image' => 'no'])
@lang('Accept')
@endcomponent
</div>

<div class="btn-acept-reject-invitation">
@component('mail::button', ['url' => $rejectUrl, 'image' => 'no'])
@lang('Reject')
@endcomponent
</div>
    
</div>

@slot('footer')
@lang('You received this email because you were invited to be a part of our community').
@endslot

@endcomponent
