<section>
    <div class="pdf-full-name">
        {{ $data->applicant->full_name }}
    </div>

    <ul class="pdf-attributes">
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_age'):</span>
            <span class="pdf-text-thin"> {{ $data->applicant->age }} </span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_weight'):</span>
            <span class="pdf-text-thin"> {{ $data->applicant->weight }} Kg</span>
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
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_height'):</span>
            <span class="pdf-text-thin"> {{ $data->applicant->height }}</span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_date'):</span>
            <span class="pdf-text-thin">
                {{ $data->created_at ? $data->created_at->format('d/m/Y') : trans('messages.pdf_no_date') }}
            </span>
        </li>
    </ul>

    @if($data->applicant->image)
        <img src="{{ $data->applicant->image->full_url }}" alt="Avatar del alumno." class="pdf-avatar-test"> 
    @else
        <img src="{{ public_path() . '/images/gender_' . $data->applicant->gender_id .'.png'}}"
            alt="Avatar del alumno." class="pdf-avatar-test">
    @endif
</section>