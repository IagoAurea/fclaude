@extends('nutrition::layouts.master')

@section('content')

<section>
    <div class="pdf-title-test">
        @lang('messages.sheet_title')
    </div>
    <div class="pdf-full-name">
        {{ $data->player_name }}
    </div>

    <ul class="pdf-attributes">
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_position'):</span>
            <span class="pdf-text-thin"> {{ $data->player_position }} </span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_age'):</span>
            <span class="pdf-text-thin"> {{ $data->player_age }} </span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_weight'):</span>
            <span class="pdf-text-thin"> {{ $data->player_weight }} Kg</span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_date'):</span> <span class="pdf-text-thin"> 
            
            {{ $data->created_at ? $data->created_at->format('d/m/Y') : trans('messages.pdf_no_date') }}
            
            </span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_num_evaluation'):</span>
            <span class="pdf-text-thin"> {{ $data->id }} </span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_evaluator'):</span>
            <span class="pdf-text-thin"> {{ $data->staff_name }} </span>
        </li>
    </ul>

    <p class="energy-border">
        <span style="color: #03002D;">@lang('messages.pdf_ul_total_energy_expenditure'): </span>
        {{ $data->total_energy_expenditure }}
    </p>


    <ul class="pdf-attributes section-1-right">
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_demarcation'):</span>
            <span class="pdf-text-thin"> {{ $data->player_demarcation }} </span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_gender'):</span> <span class="pdf-text-thin">
            
            @if(isset($data->player_gender['id']) && $data->player_gender['id'] == 1)
                @lang('messages.pdf_male')
            @elseif(isset($data->player_gender['id']) && $data->player_gender['id'] == 2)
                @lang('messages.pdf_female')
            @else
                @lang('messages.pdf_not_defined')
            @endif

            </span>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_height'):</span>
            <span class="pdf-text-thin"> {{ $data->player_height }}</span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_last_weight_height'):</span>
            <span class="pdf-text-thin"> 
                
                @if($data->player->weight_controls->count() > 0)
                    {{ explode(' ', $data->player->weight_controls[$data->player->weight_controls->count() - 1]->date)[0] }} 
                @else
                    @lang('messages.pdf_no_data')
                @endif

            </span>
        </li>
    </ul>
    
    @if($data->player->image)
        <img src="{{ $data->player->image->full_url }}" alt="Avatar del jugador" class="pdf-avatar">
    @else
        @php
            $gender = isset($data->player_gender['id']) ? $data->player_gender['id'] : '0';
        @endphp
        <img src="{{ public_path() . '/images/gender_' . $gender .'.png'}}"
        alt="Avatar del jugador." class="pdf-avatar">
    @endif

    <div class="team-image">
        @if($data->team_color && $data->team_sport_name)
            <img src="{{ $data->player->team->image ? $data->player->team->image->full_url : public_path() . '/images/sports/' . $data->team_sport_code . '/' . $data->team_sport_code . '.svg'}}" alt="Foto del equipo."> 
        @elseif(!$data->team_sport_name)  
            <img src="{{ $data->player->team->image ? $data->player->team->image->full_url : public_path() . '/images/images/logo_gray.png'}}" alt="Foto del equipo."> 
        @endif

        <br />

        @if($data->team_sport_name)
            <span> {{ $data->team_sport_name }} </span>
        @else
            <span> No Sport </span>
        @endif
    </div>

    <div class="team">
        <span class="team-name"> {{ $data->player_team }} </span>
        
        <div style="margin-top: 5px;">
            <span class="team-modality">@lang('messages.pdf_ul_modality'):
                <span class="p-text"> 
                    {{ $data->team_modality ? $data->team_modality : trans('messages.pdf_none') }} </span>
            </span>
            <br />
            <span class="team-category">@lang('messages.pdf_ul_category'): 
                <span class="p-text"> {{ str_replace('Category', '', $data->player_category) }} </span>
            </span>
        </div>
    </div>
    
</section>
<div class="pdf-section-bar">
    @lang('messages.sheet_header1')
</div>

<p align="justify" class="pdf-p-text"> {{ $data->take_supplements ? trans('messages.pdf_yes') : 'NO' }}</p>

<div class="pdf-section-bar">
    @lang('messages.sheet_header2')
</div>

    @if($data->take_supplements)
        <ul style="margin-left: 60px;" class="pdf-attributes">
            @foreach ($data->supplements as $supplement)
            <li>
                <span class="pdf-text-thin">· {{$supplement['name']}}</span>
            </li>
            @endforeach
        </ul>
    @else
        <p align="justify" class="pdf-p-text"> @lang('messages.pdf_no_specified')</p>
    @endif

<div class="pdf-section-bar">
    @lang('messages.sheet_header3')
</div>

<p align="justify" class="pdf-p-text"> {{ $data->take_diets ? trans('messages.pdf_yes') : 'NO' }}</p>

<div class="pdf-section-bar">
    @lang('messages.sheet_header4')
</div>

    @if($data->take_diets)
        <ul style="margin-left: 60px;" class="pdf-attributes">
            @foreach ($data->diets as $diet)

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

<p align="justify" class="pdf-p-text" style="color: red; font-weight: bold; font-family: Arial, Verdana, Tahoma, sans-serif;"> {{ $data->activity_factor }}</p>

<div id="footer">
    <span style="padding-left: 15px;color: #03002D;letter-spacing: 5px; font-family: Arial, Verdana, Tahoma, sans-serif;">@lang('messages.pdf_footer'): </span> {{ \Carbon\Carbon::now()->format('d/m/Y') }}
    <img src="{{ public_path() . '/images/pdf-bottom-banner.png'}}" alt="" style="left: 95px; " class="pdf-image-footer">
</div>

@endsection