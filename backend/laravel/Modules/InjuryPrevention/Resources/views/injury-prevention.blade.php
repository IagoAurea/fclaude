@extends('injuryprevention::layouts.master')

@section('content')

<section>
    <div class="pdf-title-test">
        @lang('messages.injury_title')
    </div>
    <div class="pdf-full-name">
        {{ $data->player->full_name }}
    </div>
    <ul class="pdf-attributes">
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_position'):</span> <span class="pdf-text-thin"> {{ $data->player->shirt_number }} </span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_age'):</span> <span class="pdf-text-thin"> {{ $data->player->age }} </span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_weight'):</span> <span class="pdf-text-thin"> {{ $data->player->weight }} Kg</span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_date'):</span> <span class="pdf-text-thin"> 
            
            {{ $data->created_at ? $data->created_at->format('d/m/Y') : trans('messages.pdf_no_date') }}
        
            </span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_num_evaluation'):</span> <span class="pdf-text-thin"> {{ $data->id }} </span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_evaluator'):</span> <span class="pdf-text-thin"> {{ $data->teamStaff->full_name }}</span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_injuries_number'):</span> <span class="pdf-text-thin"> {{ $data->teamStaff->full_name }} </span>
            </li>
    </ul>
    <ul class="pdf-attributes section-1-right">
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_demarcation'):</span> <span class="pdf-text-thin"> {{ $data->player->position ? $data->player->position->name : trans('messages.pdf_none') }} </span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_gender'):</span> <span class="pdf-text-thin">
            
            @if($data->player->gender['id'] == 1)         
                @lang('messages.pdf_male')  
            @elseif($data->player->gender['id'] == 2)  
                @lang('messages.pdf_female')
            @else
                @lang('messages.pdf_not_defined')     
            @endif 

            </span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_height'):</span> <span class="pdf-text-thin"> {{ $data->player->height }}</span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_closing_date'):</span> <span class="pdf-text-thin"> 
                {{ $data->date ? date('d/m/Y', strtotime($data->date)) : trans('messages.pdf_no_date') }}
            </span>
            </li>
    </ul>

         @if($data->player->gender['id'] == 1)         
            <img src="{{ $data->player->image ? $data->player->image->full_url : public_path() . '/images/gender_1.png'}}" alt="Avatar del alumno." class="pdf-avatar">  
         @elseif($data->player->gender['id'] == 2)  
            <img src="{{ $data->player->image ? $data->player->image->full_url : public_path() . '/images/gender_2.png'}}" alt="Avatar del alumno." class="pdf-avatar">
         @else
            <img src="{{ $data->player->image ? $data->player->image->full_url : public_path() . '/images/gender_0.png'}}" alt="Avatar del alumno." class="pdf-avatar"> 
         @endif
        
         <div class="team-image">
            @if($data->player->team)         
                <img src="{{ $data->player->team ? $data->player->team->image->full_url : public_path() . '/images/sports/' . $data->player->team->sport_id . '/' . $data->player->team->sport_id . '.svg'}}" alt="Foto del equipo."> 
            @elseif(!$data->player->team)  
                <img src="{{ $data->player->team ? $data->player->team->image->full_url : public_path() . '/images/images/logo_gray.png'}}" alt="Foto del equipo."> 
            @endif

            <br />

            @if($data->player->team)         
                <span> {{ $data->player->team->sport->name }} </span>
            @else
                <span> @lang('messages.pdf_no_sport') </span>
            @endif
         </div>

        <div class="team">
            <span class="team-name"> {{ $data->player->team ? $data->player->team->name : trans('messages.pdf_no_team') }} </span>
            
            <div style="margin-top: 5px;">
                <span class="team-modality">@lang('messages.pdf_ul_modality'): <span class="p-text"> {{ $data->player->team ? $data->player->team->modality : 'None' }} </span></span>
                <br />
                <span class="team-category">@lang('messages.pdf_ul_category'): <span class="p-text"> {{ str_replace('Category', '', $data->player->team ? $data->player->team->category : 'None') }} </span></span>
            </div>
            
         </div> 
    
</section>

<section style="position: relative; right: 20px;">
    <div class="pdf-section-bar">
        @lang('messages.injury_header1')
    </div>

    <p align="justify" class="pdf-p-text"> {{ $data->title }}</p>

    <div class="pdf-section-bar">
        @lang('messages.injury_header2')
    </div>

    <p align="justify" class="pdf-p-text"> {{ $data->preventiveProgramType->name }}</p>

    <div class="pdf-section-bar">
        @lang('messages.injury_header3')
    </div>

    <p align="justify" class="pdf-p-text"> 
        @if($data->injuryLocation->name)         
            <span> {{ $data->injuryLocation->name }} </span>
            <span> {{ $data->detailed_location }} </span>
        @else
            <span> {{ $data->detailed_location }} </span>
        @endif
    </p>

    <div class="pdf-section-bar">
        @lang('messages.injury_header4')
    </div>

    <p align="justify" class="pdf-p-text"> {{ $data->description }}</p>

    <div class="pdf-section-bar">
        @lang('messages.injury_header5')
    </div>

    <p align="justify" class="pdf-p-text">

        @if($data->evaluationPoints && $data->evaluationPoints < 8)         
            <span style="color: rgb(249, 47, 40)">{{ $data->evaluationPoints }}/10 @lang('messages.injury_header6')</span>
            <img style="position: absolute;right:20px;margin-right: 20px; margin-top: 10px" width="50" height="50" src="{{ public_path() . '/images/images/rfd_injuries/work_not_been_good.svg'}}" alt="Foto del resultado."> 
        @elseif($data->evaluationPoints && $data->evaluationPoints >= 8)  
            <span style="color: #00E9C5">{{ $data->evaluationPoints }}/10 @lang('messages.injury_header7')</span>
            <img style="position: absolute;right:20px;margin-right: 20px; margin-top: 10px" width="50" height="50" src="{{ public_path() . '/images/images/rfd_injuries/good_work.svg'}}" alt="Foto del resultado."> 
            @else    
            <span style="color: rgb(0, 0, 0)">@lang('messages.pdf_no_results')</span>
        @endif

    </p>
</section>

<div id="footer">
    <span style="padding-left: 15px;color: #03002D;letter-spacing: 5px;">@lang('messages.pdf_footer'): </span>
    {{ \Carbon\Carbon::now()->format('d/m/Y') }}
    <img src="{{ public_path() . '/images/pdf-bottom-banner.png'}}" alt="" style="left: 95px;" class="pdf-image-footer">
</div>

@endsection