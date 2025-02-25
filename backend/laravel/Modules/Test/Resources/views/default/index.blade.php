@extends('test::layouts.master')

@section('content')

<div class="pdf-title">
    @lang('messages.report') {{ strtoupper($data->applicable->name) }}
</div>

@if($data->applicant_type == 'Modules\\Player\\Entities\\Player')
    @include ('test::partials.player', ['data' => $data])
@else
    @include ('test::partials.alumn', ['data' => $data])
@endif

@include ('test::layouts.footer')

@endsection