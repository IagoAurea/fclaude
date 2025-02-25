@extends('effortrecovery::layouts.master')

@section('content')

@foreach ($data as $effort)
    
<section>
    <div class="pdf-title">
        @lang('messages.effort_title')
    </div>
    

            <div class="pdf-full-name">
                {{ $effort->player->full_name }}
            </div>

            <ul class="pdf-attributes">
                <li>
                   <span class="pdf-text-bold">· @lang('messages.pdf_ul_position'):</span> <span class="pdf-text-thin"> {{ $effort->player->shirt_number }} </span>
                </li>
                <li>
                   <span class="pdf-text-bold">· @lang('messages.pdf_ul_age'):</span> <span class="pdf-text-thin"> {{ $effort->player->age }} </span>
                </li>
                <li>
                   <span class="pdf-text-bold">· @lang('messages.pdf_ul_date'):</span> <span class="pdf-text-thin"> {{ $effort->player->weight }} Kg</span>
                </li>
                <li>
                   <span class="pdf-text-bold">· @lang('messages.pdf_ul_date'):</span> <span class="pdf-text-thin"> 
                    
                    {{ $effort->created_at ? $effort->created_at->format('d/m/Y') : trans('messages.pdf_no_date') }}
                    
                    </span>
                </li>
                <li>
                   <span class="pdf-text-bold">· @lang('messages.pdf_ul_num_evaluation'):</span> <span class="pdf-text-thin"> {{ $effort->id }} </span>
                </li>
             </ul>

             <p class="effort-border"><span style="color: #03002D;">@lang('messages.status'): </span>{{ $effort->latest_questionnaire_history ? $effort->latest_questionnaire_history->calculated_status : trans('messages.pdf_no_status') }} </p>
             <img style="position: absolute;left:20px;margin-left: 125px; margin-top: -10px" width="75" height="50" src="{{ public_path() . '/images/images/injury_prevention/stack.png'}}" alt="Foto del resultado.">
        

        <ul class="pdf-attributes section-1-right">
            <li>
               <span class="pdf-text-bold">· @lang('messages.pdf_ul_demarcation'):</span> <span class="pdf-text-thin"> {{ $effort->player->shirt_number }} </span>
            </li>
            <li>
               <span class="pdf-text-bold">· @lang('messages.pdf_ul_gender'):</span> <span class="pdf-text-thin">
               
                @if($effort->player->gender['id'] == 1)         
                    @lang('messages.pdf_male')  
                @elseif($effort->player->gender['id'] == 2)  
                    @lang('messages.pdf_female')
                @else
                    @lang('messages.pdf_not_defined')     
                @endif 
   
                </span>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_height'):</span> <span class="pdf-text-thin"> {{ $effort->player->height }}</span>
            </li>
         </ul>

         @if($effort->player->gender['id'] == 1)         
            <img src="{{ $effort->player->image ? $effort->player_image->image->full_url : public_path() . '/images/gender_1.png'}}" alt="Avatar del alumno." class="pdf-avatar">  
         @elseif($effort->player->gender['id'] == 2)  
            <img src="{{ $effort->player->image ? $effort->player_image->image->full_url : public_path() . '/images/gender_2.png'}}" alt="Avatar del alumno." class="pdf-avatar">
         @else
            <img src="{{ $effort->player->image ? $effort->player_image->image->full_url : public_path() . '/images/gender_0.png'}}" alt="Avatar del alumno." class="pdf-avatar"> 
         @endif

         <div class="team-image" style="left: 450px;">
            @if($effort->team && $effort->team->color && $effort->team->sport->name)         
                <img src="{{ $effort->player->team->image ? $effort->player->team->image->full_url : public_path() . '/images/sports/' . $effort->team->sport->code . '/' . $effort->team->sport->code . '.svg'}}" alt="Foto del equipo."> 
            @else
                <img src="{{ $effort->player->team->image ? $effort->player->team->image->full_url : public_path() . '/images/images/logo_gray.png'}}" alt="Foto del equipo."> 
            @endif

            <br />

            @if($effort->player->team)         
                <span> {{ $effort->player->team->name }} </span>
            @else
                <span> @lang('messages.pdf_no_sport') </span>
            @endif
         </div>

        <div class="team">
            <span class="team-name"> {{ $effort->player->team->name }} </span>
            
            <div style="margin-top: 5px;">
                <span class="team-modality">@lang('messages.pdf_ul_modality'): <span class="p-text"> {{ $effort->player->team->modality ? $effort->player->team->modality->name : trans('messages.pdf_none') }} </span></span>
                <br />
                <span class="team-category">@lang('messages.pdf_ul_category'): <span class="p-text"> {{ str_replace('Category', '', $effort->player->team->category) }} </span></span>
            </div>
            
         </div>
    
</section>
<section style="position: relative; right: 20px;">
    <div class="pdf-section-bar">
        @lang('messages.effort_header1')
    </div>

    <p align="justify" class="pdf-p-text"> {{ $effort->has_strategy ? trans('messages.pdf_yes') : 'NO' }}</p>

    <div class="pdf-section-bar">
        @lang('messages.effort_header2')
    </div>

    <p align="justify" class="pdf-p-text" > 

        @foreach ($effort->strategies as $strategie)

            @if($loop->index != 0)         
                <span class="pdf-text-thin">, {{$strategie['name']}}</span>
            @else
                <span class="pdf-text-thin">{{$strategie['name']}}</span>
            @endif

        @endforeach  

    </p>

    <div class="pdf-section-bar">
        @lang('messages.effort_header3')
    </div>

    <p align="justify" class="pdf-p-text"> {{ $effort->latest_questionnaire_history ? $effort->latest_questionnaire_history->answers[0]->name : trans('messages.pdf_no_data') }} </p>

    <div class="pdf-section-bar">
        @lang('messages.effort_header4')
    </div>

    <p align="justify" class="pdf-p-text"> {{ $effort->latest_questionnaire_history ? $effort->latest_questionnaire_history->answers[1]->name : trans('messages.pdf_no_data') }} </p>

    <div class="pdf-section-bar">
        @lang('messages.effort_header5')
    </div>

    <p align="justify" class="pdf-p-text"> {{ $effort->latest_questionnaire_history ? $effort->latest_questionnaire_history->answers[2]->name : trans('messages.pdf_no_data') }} </p>

    <div class="pdf-section-bar">
        @lang('messages.effort_header6')
    </div>

    <p align="justify" class="pdf-p-text"> {{ $effort->latest_questionnaire_history ? $effort->latest_questionnaire_history->answers[3]->name : trans('messages.pdf_no_data') }} </p>

    <div class="pdf-section-bar">
        @lang('messages.effort_header7')
    </div>

    <p align="justify" class="pdf-p-text"> {{ $effort->latest_questionnaire_history ? $effort->latest_questionnaire_history->answers[4]->name : trans('messages.pdf_no_data') }} </p>
</section>

<div class="pdf-date">
    <span style="padding-left: 15px;color: #03002D;letter-spacing: 5px; font-family: Arial, Verdana, Tahoma, sans-serif;">@lang('messages.pdf_page'): </span> 
    
    {{ $loop->index + 1 }} / {{ count($data) }}
    
    <span style="padding-left: 15px;color: #03002D;letter-spacing: 5px; font-family: Arial, Verdana, Tahoma, sans-serif;">| @lang('messages.pdf_date'): </span> 

    {{ \Carbon\Carbon::now()->format('d/m/Y') }}
</div>

@endforeach

@endsection