<section>
    <div class="pdf-full-name">
        {{ $data->applicant->full_name }}
    </div>
    <ul class="pdf-attributes">
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_position'):</span>
            <span class="pdf-text-thin"> {{ $data->applicant->shirt_number ?? '' }} </span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_age'):</span>
            <span class="pdf-text-thin"> {{ $data->applicant->age }} </span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_weight'):</span>
            <span class="pdf-text-thin"> {{ $data->applicant->weight }} Kg</span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_date'):</span> <span class="pdf-text-thin">
                {{ $data->created_at ? $data->created_at->format('d/m/Y') : trans('messages.pdf_no_date') }}
            </span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_evaluator'):</span>
            <span class="pdf-text-thin"> {{ $data->professional_direct->full_name ?? '' }} </span>
        </li>
    </ul>
    
    <div style="margin-top: 13%;"></div>

    <ul class="pdf-attributes section-1-right">
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_demarcation'):</span>
            <span class="pdf-text-thin">{{ $data->applicant->position->name ?? '' }} </span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_gender'):</span>
            <span class="pdf-text-thin">
                @if($data->applicant->gender_id == 1)
                    @lang('messages.pdf_male')
                @elseif($data->applicant->gender_id == 2)
                    @lang('messages.pdf_female')
                @else
                    @lang('messages.pdf_not_defined')
                @endif
            </span>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_height'):</span>
            <span class="pdf-text-thin"> {{ $data->applicant->height }}</span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_last_weight_height'):</span>
            <span class="pdf-text-thin"> 
                
                @if($data->applicant->weight_controls->count() > 0)
                    {{ explode(' ', $data->applicant->weight_controls[$data->applicant->weight_controls->count() - 1]->date)[0] }} 
                @else
                    @lang('messages.pdf_no_data')
                @endif

            </span>
        </li>
    </ul>
    
    @if($data->applicant->image)
        <img src="{{ $data->applicant->image->full_url }}" alt="Avatar del jugador" class="pdf-avatar-test">
    @else
        <img src="{{ public_path() . '/images/gender_' . $data->applicant->gender_id .'.png'}}"
            alt="Avatar del jugador" class="pdf-avatar-test">
    @endif

    <div class="team-image">
        @if($data->applicant->team->sport->code)
            <img src="{{ $data->applicant->team->image ?
                $data->applicant->team->image->full_url :
                public_path() . '/images/sports/' . $data->applicant->team->sport->code . '/' . $data->applicant->team->sport->code . '.svg'}}"
                alt="Foto del equipo."> 
        @elseif(!$data->applicant->team->sport->name)
            <img src="{{ public_path() . '/images/images/logo_gray.png'}}" alt="Foto del equipo"> 
        @endif
        <br />
        @if($data->applicant->team->sport->name)
            <span> {{ $data->applicant->team->sport->name }} </span>
        @else
            <span> No Sport </span>
        @endif
    </div>

    <div class="team">
        <span class="team-name"> {{ $data->applicant->team->name }} </span>
        
        <div style="margin-top: 5px;">
            <span class="team-modality">@lang('messages.pdf_ul_modality'):
                <span class="p-text">
                    {{ $data->applicant->team->modality ? $data->applicant->team->modality->name : trans('messages.pdf_none') }}
                </span>
            </span>
            <br />
            <span class="team-category">@lang('messages.pdf_ul_category'):
                <span class="p-text"> {{ str_replace('Category', '', $data->applicant->team->category) }} </span>
            </span>
        </div>
    </div>
      
</section>
