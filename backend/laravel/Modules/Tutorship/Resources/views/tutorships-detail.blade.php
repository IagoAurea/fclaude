@extends('tutorship::layouts.master')

@section('content')

@foreach ($data as $report)
    
   <section>
      <div class="pdf-title">
         @lang('messages.tutorship_title')
       </div>
       
               <div class="pdf-full-name">
                   {{ $report->alumn->full_name }}
               </div>
   
               <ul class="pdf-attributes">
                   <li>
                      <span class="pdf-text-bold" style="font-family: Arial, Verdana, Tahoma, sans-serif;">· @lang('messages.pdf_ul_list_no'):</span> <span class="pdf-text-thin"> {{ $report->alumn->list_number }} </span>
                   </li>
                   <li>
                       <span class="pdf-text-bold" style="font-family: Arial, Verdana, Tahoma, sans-serif;">· @lang('messages.pdf_ul_classroom'):</span> <span class="pdf-text-thin"> {{ $report->alumn->academicYears[0]->academicYear->title }} </span>
                    </li>
                   <li>
                      <span class="pdf-text-bold" style="font-family: Arial, Verdana, Tahoma, sans-serif;">· @lang('messages.pdf_ul_school'):</span> <span class="pdf-text-thin"> {{ $report->scholarCenter ? $report->scholarCenter->name : '' }} </span>
                   </li>
                   <li>
                      <span class="pdf-text-bold" style="font-family: Arial, Verdana, Tahoma, sans-serif;">· @lang('messages.pdf_ul_date'):</span> <span class="pdf-text-thin"> {{ $report->date ? date('d/m/Y', strtotime($report->date)) : trans('messages.pdf_no_date') }} </span>
                   </li>
                   <li>
                       <span class="pdf-text-bold" style="font-family: Arial, Verdana, Tahoma, sans-serif;">· @lang('messages.pdf_ul_num_evaluation'):</span> <span class="pdf-text-thin"> {{ $report->id }} </span>
                    </li>
                    <li>
                       <span class="pdf-text-bold" style="font-family: Arial, Verdana, Tahoma, sans-serif;">· @lang('messages.pdf_ul_school_period'):</span> <span class="pdf-text-thin"> {{ $report->alumn->academicYears[0]->academicYear->academicPeriods[$report->alumn->academicYears[0]->academicYear->academicPeriods->count() - 1]->title }} </span>
                    </li>
                   <li>
                      <span class="pdf-text-bold" style="font-family: Arial, Verdana, Tahoma, sans-serif;">· @lang('messages.pdf_ul_evaluator'):</span> <span class="pdf-text-thin"> {{ $report->tutor ? $report->tutor->name : '' }} </span>
                   </li>
                   <li>
                      <span class="pdf-text-bold" style="font-family: Arial, Verdana, Tahoma, sans-serif;">· @lang('messages.pdf_ul_type_mentoring'):</span> <span class="pdf-text-thin"> {{ $report->tutorshipType ? $report->tutorshipType->name : '' }} </span>
                   </li>
                </ul>
   
            @if($report->alumn->gender['id'] == 1)         
               <img src="{{ $report->alumn->image ? $report->alumn->image->full_url : public_path() . '/images/alumns/pupil.png'}}" alt="Avatar del alumno." class="pdf-avatar">  
            @elseif($report->alumn->gender['id'] == 2)  
               <img src="{{ $report->alumn->image ? $report->alumn->image->full_url : public_path() . '/images/alumns/student.png'}}" alt="Avatar del alumno." class="pdf-avatar">
            @else
               <img src="{{ $report->alumn->image ? $report->alumn->image->full_url : public_path() . '/images/alumns/pupil.png'}}" alt="Avatar del alumno." class="pdf-avatar"> 
            @endif
           
       
   </section>
   <div style="font-family: Arial, Verdana, Tahoma, sans-serif;" class="pdf-section-bar">
      @lang('messages.tutorship_header1')
   </div>
   
   <p style="font-family: Arial, Verdana, Tahoma, sans-serif;" align="justify" class="pdf-p-text"> {{ $report->reason }}</p>
   
   <div style="font-family: Arial, Verdana, Tahoma, sans-serif;" class="pdf-section-bar">
      @lang('messages.tutorship_header2')
   </div>
   
   <p style="font-family: Arial, Verdana, Tahoma, sans-serif;" align="justify" class="pdf-p-text"> {{ $report->resume }} </p>
   
   <div style="font-family: Arial, Verdana, Tahoma, sans-serif;" class="pdf-section-bar">
      @lang('messages.tutorship_header3')
   </div>
   
   <p style="font-family: Arial, Verdana, Tahoma, sans-serif;" align="justify" class="pdf-p-text"> {{ $report->specialistReferral ? $report->specialistReferral->name : '' }}</p>

   <div class="pdf-date">
      <span style="padding-left: 15px;color: #03002D;letter-spacing: 5px; font-family: Arial, Verdana, Tahoma, sans-serif;">@lang('messages.pdf_page'): </span> 
      
      {{ $loop->index + 1 }} / {{ count($data) }}
      
      <span style="padding-left: 15px;color: #03002D;letter-spacing: 5px; font-family: Arial, Verdana, Tahoma, sans-serif;">| @lang('messages.pdf_date'): </span> 

      {{ \Carbon\Carbon::now()->format('d/m/Y') }}
  </div>

   @if(count($data) > $loop->index + 1)
      <div style="page-break-after: always;"></div>
   @endif
@endforeach

@endsection