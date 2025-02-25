@extends('tutorship::layouts.master')

@section('content')

<section>
    <div class="pdf-title" style="font-family: Arial, Verdana, Tahoma, sans-serif;">
     @lang('messages.tutorship_title')
    </div>
    
            <div class="pdf-full-name" style="font-family: Arial, Verdana, Tahoma, sans-serif;">
                {{ $data->alumn->full_name }}
            </div>

            <ul class="pdf-attributes">
                <li>
                   <span class="pdf-text-bold" style="font-family: Arial, Verdana, Tahoma, sans-serif;">·@lang('messages.pdf_ul_list_no'):</span> <span class="pdf-text-thin"> {{ $data->alumn->list_number }} </span>
                </li>
                <li>
                    <span class="pdf-text-bold" style="font-family: Arial, Verdana, Tahoma, sans-serif;">·@lang('messages.pdf_ul_classroom'):</span> <span class="pdf-text-thin"> {{ $data->alumn->academicYears[0]->academicYear->title }} </span>
                 </li>
                <li>
                   <span class="pdf-text-bold" style="font-family: Arial, Verdana, Tahoma, sans-serif;">·@lang('messages.pdf_ul_school'):</span> <span class="pdf-text-thin"> {{ $data->scholarCenter ? $data->scholarCenter->name : '' }} </span>
                </li>
                <li>
                   <span class="pdf-text-bold" style="font-family: Arial, Verdana, Tahoma, sans-serif;">·@lang('messages.pdf_ul_date'):</span> <span class="pdf-text-thin"> {{ $data->date ? date('d/m/Y', strtotime($data->date)) : trans('messages.pdf_no_date') }} </span>
                </li>
                <li>
                    <span class="pdf-text-bold" style="font-family: Arial, Verdana, Tahoma, sans-serif;">·@lang('messages.pdf_ul_num_evaluation'):</span> <span class="pdf-text-thin"> {{ $data->id }} </span>
                 </li>
                 <li>
                    <span class="pdf-text-bold" style="font-family: Arial, Verdana, Tahoma, sans-serif;">·@lang('messages.pdf_ul_school_period'):</span> <span class="pdf-text-thin"> {{ $data->alumn->academicYears[0]->academicYear->academicPeriods[$data->alumn->academicYears[0]->academicYear->academicPeriods->count() - 1]->title }} </span>
                 </li>
                <li>
                   <span class="pdf-text-bold" style="font-family: Arial, Verdana, Tahoma, sans-serif;">·@lang('messages.pdf_ul_evaluator'):</span> <span class="pdf-text-thin"> {{ $data->tutor ? $data->tutor->name : '' }} </span>
                </li>
                <li>
                   <span class="pdf-text-bold" style="font-family: Arial, Verdana, Tahoma, sans-serif;">·@lang('messages.pdf_ul_type_mentoring'):</span> <span class="pdf-text-thin"> {{ $data->tutorshipType ? $data->tutorshipType->name : '' }} </span>
                </li>
             </ul>

         @if($data->alumn->gender['id'] == 1)         
            <img src="{{ $data->alumn->image ? $data->alumn->image->full_url : public_path() . '/images/alumns/pupil.png'}}" alt="Avatar del alumno." class="pdf-avatar">  
         @elseif($data->alumn->gender['id'] == 2)  
            <img src="{{ $data->alumn->image ? $data->alumn->image->full_url : public_path() . '/images/alumns/student.png'}}" alt="Avatar del alumno." class="pdf-avatar">
         @else
            <img src="{{ $data->alumn->image ? $data->alumn->image->full_url : public_path() . '/images/alumns/pupil.png'}}" alt="Avatar del alumno." class="pdf-avatar"> 
         @endif
        
    
</section>
<div class="pdf-section-bar" style="font-family: Arial, Verdana, Tahoma, sans-serif;">
  @lang('messages.tutorship_header1')
</div>

<p align="justify" class="pdf-p-text" style="font-family: Arial, Verdana, Tahoma, sans-serif;"> {{ $data->reason }}</p>

<div class="pdf-section-bar">
  @lang('messages.tutorship_header2')
</div>

<p align="justify" class="pdf-p-text" style="font-family: Arial, Verdana, Tahoma, sans-serif;"> {{ $data->resume }} </p>

<div class="pdf-section-bar">
  @lang('messages.tutorship_header3')
</div>

<p align="justify" class="pdf-p-text" style="font-family: Arial, Verdana, Tahoma, sans-serif;"> {{ $data->specialistReferral ? $data->specialistReferral->name : '' }}</p>

<div class="pdf-date">
    <span style="padding-left: 15px;color: #03002D;letter-spacing: 5px; font-family: Arial, Verdana, Tahoma, sans-serif;">{{ trans('messages.pdf_footer')}}: </span> {{ \Carbon\Carbon::now()->format('d/m/Y')}}
</div>



@endsection