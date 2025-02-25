@extends('exercise::layouts.master')

@section('content')
<header style="position: fixed; left: 0px; right: 0px; top: -1px;">
    <table class="table" aria-describedby="exercise-title">
        <th></th>
        <tr>
            <td>
                <div>
                    <img src="{{ public_path() . '/images/pdf-banner.png'}}" alt="" class="pdf-image-header">
                </div>
                <div class="pdf-title-header">
                    <span>{{ $exercise->title }}</span>
                </div>
            </td>
            <td>
                <div>
                    @foreach($exercise->teams as $content)
                        @if($content->sport_id === $exercise->sport_id)
                            @if($content->image)
                                <img src="{{ $content->image->full_url }}" alt="" class="pdf-image-team">
                            @endif
                        @endif
                    @endforeach
                </div>
            </td>
        </tr>
    </table>
    <table style="padding-left:25px;" aria-describedby="exercise-options">
        <th></th>
        <tr>
            <td style="padding-right: 15px;">
                <div>
                    <span class="pdf-subtitle-header cache-bold">@lang('exercise::messages.difficulty'):</span>
                    @for($i = 0; $i < 5; $i++)
                        @if($exercise->difficulty <= $i )
                            <img src="{{ public_path() . '/images/start-difficulty-incomplete.png'}}" alt="" style=" width: 15px; padding-right: 8px">
                            @else <img src="{{ public_path() . '/images/start-difficulty.png'}}" alt="" style=" width: 15px; padding-right: 8px">  
                       @endif
                    @endfor
                </div>
            </td>
            <td style="padding-right: 15px;">
                <div style="text-align:center;">
                    <span class="pdf-subtitle-header">@lang('exercise::messages.intensity'):</span>
                    @if($exercise->intensityRelation)
                        <img src="{{ $exercise->intensityRelation->image->full_url }}" alt="" style="width:25px; height: 25px; position: relative; top: 7px;">
                        @else <span class="cache-bold" style="color: #03002D; font-size: 18px;  padding-left:8px;">N/A</span>
                    @endif
                </div>
            </td>
            <td style="padding-right: 15px;">
                <div>
                    <span class="cache-bold pdf-subtitle-header pdf-underline">
                        @lang('exercise::messages.duration'):
                    </span>
                    {{ $exercise->duration }} min.

                </div>
            </td>
        </tr>
    </table>
</header>

<footer style="position: fixed; left: 0px; right: 0px; bottom: -1px; font-family: Arial, Verdana, Tahoma, sans-serif;; color: #00e9c5; width: 100%;">
        <div style="">
            <div style="padding-left:178px;width: 100%;">
                <span class="cache-bold" style="padding-right: 15px;color: #00e9c5;letter-spacing: 5px; font-size: 20px; font-family: Arial, Verdana, Tahoma, sans-serif;">
                    @lang('exercise::messages.exercise_generated')
                </span>
                <img src="{{ public_path() . '/images/pdf-bottom-banner.png'}}" style="width: 380px; position:relative; right: 42px; top: 10px;" alt="">
            </div>
        </div>
</footer>

<section>
    @if(strlen($exercise->title) > 45 and strlen($exercise->title) <= 90)
        <div style="margin-top: 40px"></div>
        @elseif(strlen($exercise->title) > 90)<div style="margin-top: 80px"></div>
    @endif
    <table class="table" aria-describedby="exercise">
        <th></th>
        <tr>
            <td style="">
                <div style="border-style: solid;  border-color: #00e9c5;   width: 550px;  height: 390px; display: relative; right: 10px; margin-left: 10px;">
                    @if($exercise->image) 
                        <img src="{{ $exercise->image->full_url }}" alt="" width="540" height="380"  style=" padding: 4px;">
                    @else
                        <img src="{{ $exercise->sport->imageExercise->full_url }}" width="540" height="380" alt="" style="padding: 4px;">
                    @endif
                </div>
            </td>
            <td>
                <div style="padding-left: 10px;">
                    <span class="cache-bold pdf-subtitle-header pdf-underline">
                        @lang('exercise::messages.duration_repetitions'):
                    </span>
                    <span class="cache-book" style="font-size: 14px;color: #03002D;">
                        {{ $exercise->duration_repetitions }} min.
                    </span>
                </div>
                <div style="padding-left: 15px; padding-bottom: 20px;">
                    <span class="cache-bold pdf-item-list">
                        <span style="color: #00e9c5;">-</span> @lang('exercise::messages.break_repetitions'):
                    </span>
                    <span class="cache-book" style="font-size: 14px;color: #03002D;">
                        {{ $exercise->break_repetitions }} sg.
                    </span>
                </div>
                <div style="padding-left: 10px;">
                    <span class="cache-bold pdf-subtitle-header pdf-underline">
                        @lang('exercise::messages.series'):
                    </span>
                    <span class="cache-book" style="font-size: 18px;color: #03002D;">
                        {{ $exercise->series }}
                    </span>
                </div>
                <div style="padding-left: 15px; padding-bottom: 20px;">
                    <span class="cache-bold pdf-item-list">
                        <span style="color: #00e9c5;">-</span> @lang('exercise::messages.break_series'):
                    </span>
                    <span class="cache-book" style="font-size: 14px;color: #03002D;">
                        {{ $exercise->break_series }} min.
                    </span>
                </div>
                <div style="padding-left: 10px; padding-bottom: 20px;">
                    <div class="cache-bold pdf-subtitle-header pdf-underline" style="width:110px;">
                        @lang('exercise::messages.distribution'):
                    </div>
                    <div class="cache-book" style="font-size: 18px;padding-left:8px;color: #03002D;">
                        {{ $exercise->distribution->name }}
                    </div>
                </div>
                <div style="padding-left: 10px; padding-bottom: 20px;">
                    <div class="cache-bold pdf-subtitle-header pdf-underline" style="width:110px;">
                        @lang('exercise::messages.dimentions'):
                    </div>
                    <div class="cache-book" style="font-size: 18px;padding-left:8px;color: #03002D;">
                        {{ $exercise->dimentions }}
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <div class="cache-book" style="padding-top: 10px; position: relative; left: 340px;color: #03002D">
                <img src="{{ public_path() . '/images/logo_green.png'}}" alt="" class="pfd-logo">
                <span>
                    @lang('exercise::messages.create_user') {{ $exercise->user->full_name  }}
                </span>
            </div>
        </tr>
    </table>
    <div style="">
        <div style="margin: 8px 10px;">
            <div class="cache-bold pdf-subtitle-header pdf-underline" style="width:110px;">
                @lang('exercise::messages.description'):
            </div>
            <div class="cache-book" style="width: 650x; color: #03002D; font-size: 14px">{{ $exercise->description }}</div>
        </div>
        <div class="">
            <img src="{{ public_path() . '/images/training_cone.png'}}" alt="" style=" width: 20px; position:relative;padding: 0px; margin:0px; left:8px;"> 
            <span class="cache-bold pdf-subtitle-header pdf-underline">
                @lang('exercise::messages.materials')
            </span>
        </div>

        <div class="width: 850px; position:relative; right: 20px; text-align: center; font-size: 16px; color: #03002D;">
        @if(!$exercise->materials)
                <div class="cache-book" style="text-align: center; color: #03002D; width: 100%; ">
                    <span style="font-size: 18px; font-family: Arial, Verdana, Tahoma, sans-serif;">@lang('exercise::messages.not_results_fount')</span>
                </div>
                @else
                    <div class="cache-book" style="padding-left: 20px;">
                        @foreach($exercise->materials as $material)
                            @foreach($material as $item)
                                @if($loop->index === 3)
                                    <span style="padding-right:7px;">({{$item}})</span>
                                @endif

                                @if($loop->index === 2)
                                    <span style="color: #00e9c5">-</span> {{$item}}
                                @endif
                            @endforeach
                        @endforeach
                    </div>
        @endif
        </div>
    </div>
    <div style="page-break-before: always;"></div>
    @if(strlen($exercise->title) > 45 and strlen($exercise->title) <= 90)
        <div style="margin-top: 40px"></div>
        @elseif(strlen($exercise->title) > 90)<div style="margin-top: 80px"></div>
    @endif
    <div>
        <div style="width: 100%; text-align: center;">
            <div class="cache-bold pdf-subtitle-header">
                - @lang('exercise::messages.objectives_title') -
            </div>
        </div>
        <div style="position:relative; right: 20px; width: 850px;  margin:0; padding:0; background: #050C44; color: white; font-family: Arial, Verdana, Tahoma, sans-serif; font-size: 16px; border-top: 5px solid #00e9c5;">
            @if(count($exercise->contents) > 0)
                <div>
                    @foreach($exercise->contents as $content)
                            @if($content->image)
                                <img style="width:25px; height:25px; background-color: #fff; padding: 3px; margin: 8px 0px 0px 50px; margin-top:8px;"  alt="" src={{ $content->image->full_url }} />
                            @endif
                            <span style="padding-right: 30px;">{{$content->name}}</span>
                    @endforeach
                </div>
                @else
                    <div style="text-align:center;">
                        <span style="">@lang('exercise::messages.not_results_fount') </span>
                    </div>
            @endif
        </div>
        <table style="position:relative; text-align:center;font-size: 16px; color: #03002D;" aria-describedby="targets">
            <th></th>
            @foreach($exercise->contents as $content)
                <td>
                    @foreach($exercise->targets as $target)
                        @if($content->id === $target->content_exercise_id)
                            <div class="cache-book" style="width: 190px; text-align: center" >
                                {{$target->name}}
                            </div>
                        @endif
                    @endforeach
                </td>
            @endforeach
        </table>
    </div>
</section>
    

@endsection