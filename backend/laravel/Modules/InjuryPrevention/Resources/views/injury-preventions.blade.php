@extends('psychology::layouts.master')

@section('content')

@foreach ($data['injury_preventions'] as $injury)
    
    <section>
        <div class="pdf-title-test">
            @lang('messages.injury_title')
        </div>
    
        <div class="pdf-full-name">
            {{ $injury->player->full_name }}
        </div>
    
        <ul class="pdf-attributes">
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_position'):</span> <span class="pdf-text-thin"> {{ $injury->player->shirt_number }} </span>
            </li>
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_age'):</span> <span class="pdf-text-thin"> {{ $injury->player->age }} </span>
            </li>
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_weight'):</span> <span class="pdf-text-thin"> {{ $injury->player->weight }} Kg</span>
            </li>
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_date'):</span> <span class="pdf-text-thin"> 
                
                {{ $injury->created_at ? $injury->created_at->format('d/m/Y') : trans('messages.pdf_no_date') }}
            
                </span>
            </li>
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_num_evaluation'):</span> <span class="pdf-text-thin"> {{ $injury->id }} </span>
            </li>
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_evaluator'):</span> <span class="pdf-text-thin"> {{ $injury->teamStaff->full_name }}</span>
            </li>
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_injuries_number'):</span> <span class="pdf-text-thin"> {{ $injury->teamStaff->full_name }} </span>
                </li>
        </ul>
    
        <ul class="pdf-attributes section-1-right">
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_demarcation'):</span> <span class="pdf-text-thin"> {{ $injury->player->position ? $injury->player->position->name : trans('messages.pdf_none') }} </span>
            </li>
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_gender'):</span> <span class="pdf-text-thin">
                
                @if($injury->player->gender['id'] == 1)         
                    @lang('messages.pdf_male')  
                @elseif($injury->player->gender['id'] == 2)  
                    @lang('messages.pdf_female')
                @else
                    @lang('messages.pdf_not_defined')     
                @endif 
    
                </span>
            </li>
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_height'):</span> <span class="pdf-text-thin"> {{ $injury->player->height }}</span>
            </li>
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_closing_date'):</span> <span class="pdf-text-thin"> 
                    {{ $injury->date ? date('d/m/Y', strtotime($injury->date)) : trans('messages.pdf_no_date') }}
                </span>
                </li>
        </ul>
    
             @if($injury->player->gender['id'] == 1)         
                <img src="{{ $injury->player->image ? $injury->player->image->full_url : public_path() . '/images/gender_1.png'}}" alt="Avatar del alumno." class="pdf-avatar">  
             @elseif($injury->player->gender['id'] == 2)  
                <img src="{{ $injury->player->image ? $injury->player->image->full_url : public_path() . '/images/gender_2.png'}}" alt="Avatar del alumno." class="pdf-avatar">
             @else
                <img src="{{ $injury->player->image ? $injury->player->image->full_url : public_path() . '/images/gender_0.png'}}" alt="Avatar del alumno." class="pdf-avatar"> 
             @endif
            
             <div class="team-image">
                @if($injury->player->team)         
                    <img src="{{ $injury->player->team ? $injury->player->team->image->full_url : public_path() . '/images/sports/' . $injury->player->team->sport_id . '/' . $injury->player->team->sport_id . '.svg'}}" alt="Foto del equipo."> 
                @elseif(!$injury->player->team)  
                    <img src="{{ $injury->player->team ? $injury->player->team->image->full_url : public_path() . '/images/images/logo_gray.png'}}" alt="Foto del equipo."> 
                @endif
    
                <br />
    
                @if($injury->player->team)         
                    <span> {{ $injury->player->team->sport->name }} </span>
                @else
                    <span> @lang('messages.pdf_no_sport') </span>
                @endif
             </div>
    
            <div class="team">
                <span class="team-name"> {{ $injury->player->team ? $injury->player->team->name : trans('messages.pdf_no_team') }} </span>
                
                <div style="margin-top: 5px;">
                    <span class="team-modality">@lang('messages.pdf_ul_modality'): <span class="p-text"> {{ $injury->player->team ? $injury->player->team->modality : 'None' }} </span></span>
                    <br />
                    <span class="team-category">@lang('messages.pdf_ul_category'): <span class="p-text"> {{ str_replace('Category', '', $injury->player->team ? $injury->player->team->category : 'None') }} </span></span>
                </div>
                
             </div>
        
    </section>
    <section style="position: relative; right: 20px;">
        <div class="pdf-section-bar">
            @lang('messages.injury_header1')
        </div>
        
        <p align="justify" class="pdf-p-text"> {{ $injury->title }}</p>
        
        <div class="pdf-section-bar">
            @lang('messages.injury_header2')
        </div>
        
        <p align="justify" class="pdf-p-text"> {{ $injury->preventiveProgramType->name }}</p>
        
        <div class="pdf-section-bar">
            @lang('messages.injury_header3')
        </div>
        
        <p align="justify" class="pdf-p-text"> 
            @if($injury->injuryLocation->name)         
                <span> {{ $injury->injuryLocation->name }} </span>
                <span> {{ $injury->detailed_location }} </span>
            @else
                <span> {{ $injury->detailed_location }} </span>
            @endif
        </p>
        
        <div class="pdf-section-bar">
            @lang('messages.injury_header4')
        </div>
        
        <p align="justify" class="pdf-p-text"> {{ $injury->description }}</p>
        
        <div class="pdf-section-bar">
            @lang('messages.injury_header5')
        </div>
        
        <p align="justify" class="pdf-p-text">
        
            @if($injury->evaluationPoints && $injury->evaluationPoints < 8)         
                <span style="color: rgb(249, 47, 40); font-family: Arial, Verdana, Tahoma, sans-serif;">{{ $injury->evaluationPoints }}/10 @lang('messages.injury_header6')</span>
                <img style="position: absolute;right:20px;margin-right: 20px; margin-top: 10px" width="50" height="50" src="{{ public_path() . '/images/images/rfd_injuries/work_not_been_good.svg'}}" alt="Foto del resultado."> 
            @elseif($injury->evaluationPoints && $injury->evaluationPoints >= 8)  
                <span style="color: #00E9C5">{{ $injury->evaluationPoints }}/10 @lang('messages.injury_header7')</span>
                <img style="position: absolute;right:20px;margin-right: 20px; margin-top: 10px" width="50" height="50" src="{{ public_path() . '/images/images/rfd_injuries/good_work.svg'}}" alt="Foto del resultado."> 
                @else    
                <span style="color: rgb(0, 0, 0)">@lang('messages.pdf_no_results')</span>
            @endif
        
        </p>
    </section>

    <div id="footer">
        <span style="padding-left: 15px;color: #03002D;letter-spacing: 5px; font-family: Arial, Verdana, Tahoma, sans-serif;">@lang('messages.pdf_page'): </span> 
        
        {{ $loop->index + 1 }} / {{ count($data) }}
        
        <span style="padding-left: 15px;color: #03002D;letter-spacing: 5px; font-family: Arial, Verdana, Tahoma, sans-serif;">| @lang('messages.pdf_date'): </span> 
  
        {{ \Carbon\Carbon::now()->format('d/m/Y') }}
        <img src="{{ public_path() . '/images/pdf-bottom-banner.png'}}" alt="" style="left: 120px;" class="pdf-image-footer">
    </div>
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
@endforeach

@endsection