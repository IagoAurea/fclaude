@extends('test::layouts.master')

@section('content')

<div class="pdf-title-test">
    @lang('messages.report') {{ strtoupper($data->applicable->name) }}
</div>

@if($data->applicant_type == 'Modules\\Player\\Entities\\Player')
    @include ('test::partials.player', ['data' => $data])
@else
    @include ('test::partials.alumn', ['data' => $data])
@endif

@foreach($data->answers as $answer)
    <div class="pdf-section-bar-test">
        {{ $answer->question }}
    </div>
    <p align="justify" class="pdf-p-text">
        {{ strtoupper($answer->question) }}
    </p>
@endforeach

@endsection