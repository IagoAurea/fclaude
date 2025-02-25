@extends('psychology::layouts.master')

@section('content')

<section>
    <div class="pdf-title-test">
        @lang('messages.psycology_title')
    </div>
    
    <div class="pdf-full-name">
        {{ $data->player_name }}
    </div>

    <ul class="pdf-attributes">
        <li>
            <span class="pdf-text-bold">
                · @lang('messages.pdf_ul_position') :
            </span>
            <span class="pdf-text-thin">
                {{ $data->player_position }}
            </span>
        </li>
        <li>
            <span class="pdf-text-bold">
                · @lang('messages.pdf_ul_age') :
            </span>
            <span class="pdf-text-thin">
                {{ $data->player_age }}
            </span>
        </li>
        <li>
            <span class="pdf-text-bold">
                · @lang('messages.pdf_ul_weight') :
            </span>
            <span class="pdf-text-thin">
                {{ $data->player_weight }}
                Kg</span>
        </li>
        <li>
            <span class="pdf-text-bold">
                · @lang('messages.pdf_ul_date') :
            </span>
            <span class="pdf-text-thin">
                {{ $data->date ? date('d/m/Y', strtotime($data->dae)) : trans('messages.pdf_no_date') }} 
            </span>
        </li>
        <li>
            <span class="pdf-text-bold">
                · @lang('messages.pdf_ul_num_evaluation') :
            </span>
            <span class="pdf-text-thin">
                {{ $data->id }}
            </span>
        </li>
        <li>
            <span class="pdf-text-bold">
                · @lang('messages.pdf_ul_evaluator') :
            </span>
            <span class="pdf-text-thin">
                {{ $data->team_staff_name }},
                {{ $data->psychology_specialist_name }}
            </span>
        </li>
    </ul>

    <ul class="pdf-attributes section-1-right">
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_demarcation') :</span>
            <span class="pdf-text-thin"> {{ $data->player_demarcation }} </span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_gender') :</span>
            <span class="pdf-text-thin">
                @if(isset($data->player_gender['id']) && $data->player_gender['id'] == 1)
                    @lang('messages.pdf_male')
                @elseif(isset($data->player_gender['id']) && $data->player_gender['id'] == 2)
                    @lang('messages.pdf_female')
                @else
                    @lang('messages.pdf_not_defined')
                @endif
            </span>
        </li>
        <li>
            <span class="pdf-text-bold">
                · @lang('messages.pdf_ul_height') :
            </span>
            <span class="pdf-text-thin">
                {{ $data->player_height }}
            </span>
        </li>
    </ul>

    @if(isset($data->player_gender['id']) && $data->player_gender['id'] == 1)
        <img
            src="{{ $data->player->image ? $data->player->image->full_url : public_path() . '/images/gender_1.png'}}"
            alt="Avatar del alumno."
            class="pdf-avatar"
        >
    @elseif(isset($data->player_gender['id']) && $data->player_gender['id'] == 2)
        <img src="{{ $data->player->image ? $data->player->image->full_url : public_path() . '/images/gender_2.png'}}" alt="Avatar del alumno." class="pdf-avatar">
    @else
        <img src="{{ $data->player->image ? $data->player->image->full_url : public_path() . '/images/gender_0.png'}}" alt="Avatar del alumno." class="pdf-avatar"> 
    @endif
        
    <div class="team-image">
        @if($data->team_sport_name)
            <img
                src="{{
                    $data->player->team->image ?
                        $data->player->team->image->full_url
                        :
                        public_path() . '/images/sports/' . $data->team_sport_code . '/' . $data->team_sport_code . '.svg'
                    }}"
                alt="Foto del equipo."
            >
        @elseif(!$data->team_sport_name)
            <img src="{{
                    $data->player->team->image ?
                    $data->player->team->image->full_url
                    :
                    public_path() . '/images/images/logo_gray.png'
                }}"
                alt="Foto del equipo."
            >
        @endif

        <br />

        @if($data->team_sport_name)
            <span class="cache-book"> {{ $data->team_sport_name }} </span>
        @else
            <span class="cache-book"> @lang('messages.pdf_no_sport') </span>
        @endif
    </div>

    <div class="team">
        <span class="team-name cache-bold"> {{ $data->player_team }} </span>
        
        <div style="margin-top: 5px; margin-bottom: 40px;">
            <span class="team-modality">
                @lang('messages.pdf_ul_modality') :
                <span class="p-text">
                    {{ $data->team_modality ? $data->team_modality : trans('messages.pdf_none') }}
                </span>
            </span>
            <br />
            <span class="team-category">
                @lang('messages.pdf_ul_category') :
                <span class="p-text">
                    {{ str_replace('Category', '', $data->player_category) }}
                </span>
            </span>
        </div>
        
    </div>
    
</section>
<section style="position: relative; right: 20px;">
    <div  class="cache-bold pdf-section-bar-notmargin">
        @lang('messages.report_header1')
    </div>

    <p align="justify" class="pdf-text-thin" style="margin-left: 60px;"> {{ $data->cause }}</p>

    <div class="cache-bold pdf-section-bar-notmargin">
        @lang('messages.report_header2')
    </div>

    <p align="justify" class="pdf-text-thin" style="margin-left: 60px;"> {{ $data->anamnesis }}</p>

    <div class="cache-bold pdf-section-bar-notmargin">
        @lang('messages.report_header3')
    </div>

    <p align="justify" class="pdf-text-thin" style="margin-left: 60px;"> {{ $data->presumptive_diagnosis }}</p>

    <div class="cache-bold pdf-section-bar-notmargin">
        @lang('messages.report_header4')
    </div>

    <p align="justify" class="pdf-text-thin" style="margin-left: 60px;">
        {{ $data->psychology_specialist_name ? $data->psychology_specialist_name : '' }}
    </p>
</section>

<div id="footer">
    <span style="padding-left: 15px;color: #03002D;letter-spacing: 5px;">
        @lang('messages.pdf_footer') :
    </span> 
    {{ \Carbon\Carbon::now()->format('d/m/Y') }}
    <img src="{{ public_path() . '/images/pdf-bottom-banner.png'}}" alt="" style="left: 95px;" class="pdf-image-footer">
</div>

@endsection