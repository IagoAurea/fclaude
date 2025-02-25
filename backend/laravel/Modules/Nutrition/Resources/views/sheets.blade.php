@extends('nutrition::layouts.master')

@section('content')

@foreach ($data as $sheet)
<section>
        <div class="pdf-title-test">
            @lang('messages.sheet_title')
        </div>
        
        <div class="pdf-full-name">
            {{ $sheet->player_name }}
        </div> 

        <ul class="pdf-attributes">
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_position'):</span>
                <span class="pdf-text-thin"> {{ $sheet->player_position }} </span>
            </li>
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_age'):</span>
                <span class="pdf-text-thin"> {{ $sheet->player_age }} </span>
            </li>
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_weight'):</span>
                <span class="pdf-text-thin"> {{ $sheet->player_weight }} Kg</span>
            </li>
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_date'):</span>
                <span class="pdf-text-thin">
                    {{ $sheet->created_at ? $sheet->created_at->format('d/m/Y') : trans('messages.pdf_no_date') }}
                </span>
            </li>
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_num_evaluation'):</span>
                <span class="pdf-text-thin"> {{ $sheet->id }} </span>
            </li>
            <li>
                <span class="pdf-text-bold">· @lang('messages.pdf_ul_evaluator'):</span>
                <span class="pdf-text-thin"> {{ $sheet->staff_name }} </span>
            </li>
        </ul>
    
                 <p class="energy-border">
                    <span style="color: #03002D; font-family: Arial, Verdana, Tahoma, sans-serif;">
                        @lang('messages.pdf_ul_total_energy_expenditure'):
                    </span>
                    {{ $sheet->total_energy_expenditure }}
                </p>
            
    
            <ul class="pdf-attributes section-1-right">
                <li>
                   <span class="pdf-text-bold">· @lang('messages.pdf_ul_demarcation'):</span>
                   <span class="pdf-text-thin"> {{ $sheet->player_demarcation }} </span>
                </li>
                <li>
                   <span class="pdf-text-bold">· @lang('messages.pdf_ul_gender'):</span> <span class="pdf-text-thin">
                   
                    @if(isset($sheet->player_gender['id']) && $sheet->player_gender['id'] == 1)
                        @lang('messages.pdf_male')  
                    @elseif(isset($sheet->player_gender['id']) && $sheet->player_gender['id'] == 2)
                        @lang('messages.pdf_female')
                    @else
                        @lang('messages.pdf_not_defined')
                    @endif
       
                    </span>
                    <span class="pdf-text-bold">· @lang('messages.pdf_ul_height'):</span>
                    <span class="pdf-text-thin"> {{ $sheet->player_height }}</span>
                </li>
                <li>
                    <span class="pdf-text-bold">· @lang('messages.pdf_ul_last_weight_height'):</span>
                    <span class="pdf-text-thin">
                        @if($sheet->player->weight_controls->count() > 0)
                            {{ explode(' ', $sheet->player->weight_controls[$sheet->player->weight_controls->count() - 1]->date)[0] }} 
                        @else
                            @lang('messages.pdf_no_data')
                        @endif
                    </span>
                </li>
             </ul>
    
            @if($sheet->player->image)
                <img src="{{ $sheet->player->image->full_url }}" alt="Avatar del jugador" class="pdf-avatar">
            @else
                @php
                    $gender = isset($sheet->player_gender['id']) ? $sheet->player_gender['id'] : '0';
                @endphp
                <img src="{{ public_path() . '/images/gender_' . $gender .'.png'}}"
                alt="Avatar del jugador." class="pdf-avatar">
            @endif
    
             <div class="team-image">
                @if($sheet->team_color && $sheet->team_sport_name)
                    <img src="{{ $sheet->player->team->image ? $sheet->player->team->image->full_url : public_path() . '/images/sports/' . $sheet->team_sport_code . '/' . $sheet->team_sport_code . '.svg'}}" alt="Foto del equipo."> 
                @elseif(!$sheet->team_sport_name)
                    <img src="{{ $sheet->player->team->image ? $sheet->player->team->image->full_url : public_path() . '/images/images/logo_gray.png'}}" alt="Foto del equipo."> 
                @endif
    
                <br />
    
                @if($sheet->team_sport_name)
                    <span> {{ $sheet->team_sport_name }} </span>
                @else
                    <span> No Sport </span>
                @endif
             </div>
    
            <div class="team">
                <span class="team-name"> {{ $sheet->player_team }} </span>
                
                <div style="margin-top: 5px;">
                    <span class="team-modality">@lang('messages.pdf_ul_modality'):
                        <span class="p-text">
                            {{ $sheet->team_modality ? $sheet->team_modality : trans('messages.pdf_none') }}
                        </span>
                    </span>
                    <br />
                    <span class="team-category">@lang('messages.pdf_ul_category'):
                        <span class="p-text"> {{ str_replace('Category', '', $sheet->player_category) }} </span>
                    </span>
                </div>
                
             </div>
        
    </section>
    <div class="pdf-section-bar">
        @lang('messages.sheet_header1')
    </div>
    
    <p align="justify" class="pdf-p-text">
        {{ $sheet->take_supplements ? trans('messages.pdf_yes') : 'NO' }}
    </p>
    
    <div class="pdf-section-bar">
        @lang('messages.sheet_header2')
    </div>
    
        @if($sheet->take_supplements)
            <ul style="margin-left: 60px;" class="pdf-attributes">
                @foreach ($sheet->supplements as $supplement)
                    <li>
                        <span class="pdf-text-thin">· {{$supplement['name']}}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p align="justify" class="pdf-p-text">
                @lang('messages.pdf_no_specified')
            </p>
        @endif
    
    <div class="pdf-section-bar">
        @lang('messages.sheet_header3')
    </div>
    
    <p align="justify" class="pdf-p-text">
        {{ $sheet->take_diets ? trans('messages.pdf_yes') : 'NO' }}
    </p>
    
    <div class="pdf-section-bar">
        @lang('messages.sheet_header4')
    </div>
    
        @if($sheet->take_diets)
            <ul style="margin-left: 60px;" class="pdf-attributes">
                @foreach ($sheet->diets as $diet)
                    <li>
                        <span class="pdf-text-thin">· {{$diet['name']}}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p align="justify" class="pdf-p-text"> @lang('messages.pdf_no_specified')</p>
        @endif
    
    <div class="pdf-section-bar">
        @lang('messages.sheet_header5')
    </div>
    
    <p align="justify" class="pdf-p-text" style="color: red; font-weight: bold;">
        {{ $sheet->activity_factor }}
    </p>
    <div id="footer">
        <span style="padding-left: 15px;color: #03002D;letter-spacing: 5px;">
            @lang('messages.pdf_page'):
        </span>
        
        {{ $loop->index + 1 }} / {{ count($data) }}
        
        <span style="padding-left: 15px;color: #03002D;letter-spacing: 5px;">
            | @lang('messages.pdf_date'):
        </span>
  
        {{ \Carbon\Carbon::now()->format('d/m/Y') }}

        <img src="{{ public_path() . '/images/pdf-bottom-banner.png'}}" alt="" style="left: 160px;" class="pdf-image-footer">
    </div>
    @if(count($data) > $loop->index + 1)
        <div style="page-break-after: always;">
        </div>
    @endif
@endforeach

@endsection