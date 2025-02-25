@extends('psychology::layouts.master')

@section('content')

@foreach ($data as $report)
    
    <section>
        <div class="pdf-title-test">
            @lang('messages.psycology_title')
        </div>
        <div class="pdf-full-name">
            {{ $report->player_name }}
        </div>

        <ul class="pdf-attributes">
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_position'):</span><span class="pdf-text-thin"> {{ $report->player_position }} </span>
            </li>
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_age'):</span> <span class="pdf-text-thin"> {{ $report->player_age }} </span>
            </li>
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_weight'):</span> <span class="pdf-text-thin"> {{ $report->player_weight }} Kg</span>
            </li>
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_date'):</span> <span class="pdf-text-thin"> {{ $report->date ? date('d/m/Y', strtotime($report->date)) : trans('messages.pdf_no_date') }} </span>
            </li>
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_num_evaluation'):</span> <span class="pdf-text-thin"> {{ $report->id }} </span>
            </li>
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_evaluator'):</span> <span class="pdf-text-thin"> {{ $report->team_staff_name }}, {{ $report->psychology_specialist_name }}</span>
            </li>
        </ul>
            
        <ul class="pdf-attributes section-1-right">
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_demarcation'):</span> <span class="pdf-text-thin"> {{ $report->player_demarcation }} </span>
            </li>
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_gender'):</span> <span class="pdf-text-thin">
                
                @if($report->player_gender['id'] == 1)         
                    @lang('messages.pdf_male')  
                @elseif($report->player_gender['id'] == 2)  
                    @lang('messages.pdf_female')  
                @else
                    @lang('messages.pdf_not_defined')     
                @endif 
    
                </span>
            </li>
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_height'):</span> <span class="pdf-text-thin"> {{ $report->player_height }}</span>
            </li>
        </ul>
    
        @if($report->player_gender['id'] == 1)
            <img src="{{ $report->player->image ? $report->player->image->full_url : public_path() . '/images/gender_1.png'}}" alt="Avatar del alumno." class="pdf-avatar">  
        @elseif($report->player_gender['id'] == 2)  
            <img src="{{ $report->player->image ? $report->player->image->full_url : public_path() . '/images/gender_2.png'}}" alt="Avatar del alumno." class="pdf-avatar">
        @else
            <img src="{{ $report->player->image ? $report->player->image->full_url : public_path() . '/images/gender_0.png'}}" alt="Avatar del alumno." class="pdf-avatar"> 
        @endif
            
        <div class="team-image">
            @if($report->team_sport_name)         
                <img src="{{ $report->player->team->image ? $report->player->team->image->full_url : public_path() . '/images/sports/' . $report->team_sport_code . '/' . $report->team_sport_code . '.svg'}}" alt="Foto del equipo."> 
            @elseif(!$report->team_sport_name)  
                <img src="{{ $report->player->team->image ? $report->player->team->image->full_url : public_path() . '/images/images/logo_gray.png'}}" alt="Foto del equipo."> 
            @endif

            <br />

            @if($report->team_sport_name)         
                <span class="cache-book"> {{ $report->team_sport_name }} </span>
            @else
                <span class="cache-book"> @lang('messages.pdf_no_sport') </span>
            @endif
        </div>
    
        <div class="team">
            <span class="team-name cache-book"> {{ $report->player_team }} </span>
            <div style="margin-top: 5px; margin-bottom: 40px;">
                <span class="team-modality">@lang('messages.pdf_ul_modality'): <span class="p-text"> {{ $report->team_modality ? $report->team_modality : trans('messages.pdf_none') }} </span></span>
                <br />
                <span class="team-category">@lang('messages.pdf_ul_category'): <span class="p-text"> {{ str_replace('Category', '', $report->player_category) }} </span></span>
            </div>
        </div>
        
    </section>
    <section style="position: relative; right: 20px;">
        <div class="pdf-section-bar cache-bold">
            @lang('messages.report_header1')
        </div>
        
        <p align="justify" class="pdf-p-text" style="margin-left: 60px;"> {{ $report->cause }}</p>
        
        <div class="pdf-section-bar cache-bold">
            @lang('messages.report_header2')
        </div>
        
        <p align="justify" class="pdf-p-text" style="margin-left: 60px;"> {{ $report->anamnesis }}</p>
        
        <div class="pdf-section-bar cache-bold">
            @lang('messages.report_header3')
        </div>
        
        <p align="justify" class="pdf-p-text" style="margin-left: 60px;"> {{ $report->presumptive_diagnosis }}</p>
        
        <div class="pdf-section-bar cache-bold">
            @lang('messages.report_header4')
        </div>
        
        <p align="justify" class="pdf-p-text" style="margin-left: 60px;"> 
            {{ $report->psychology_specialist_name ? $report->psychology_specialist_name : '' }}
        </p>
    </section>

    <div id="footer">
        <span style="padding-left: 15px;color: #03002D;letter-spacing: 5px;">@lang('messages.pdf_page'): </span> 
        
        {{ $loop->index + 1 }} / {{ count($data) }}
        
        <span style="padding-left: 15px;color: #03002D;letter-spacing: 5px;">| @lang('messages.pdf_date'): </span> 
  
        {{ \Carbon\Carbon::now()->format('d/m/Y') }}
        <img src="{{ public_path() . '/images/pdf-bottom-banner.png'}}" alt="" style="left: 170px;" class="pdf-image-footer">
    </div>
    @if(count($data) > $loop->index + 1)
        <div style="page-break-after: always;"></div>
    @endif
@endforeach

@endsection