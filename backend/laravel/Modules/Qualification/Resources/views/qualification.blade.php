@extends('qualification::layouts.master')

@section('content')
<section>
    <div class="pdf-title-test">
      @lang('messages.rubric_title')
    </div>
    <div class="pdf-full-name">
        <span>{{$alumn->full_name}}</span>
    </div>
    <ul class="pdf-attributes">
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_list_no'):</span> 
            <span class="pdf-text-thin">{{$alumn->list_number}}</span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_classroom'):</span> 
            <span class="pdf-text-thin"> {{$alumn->academicYears[0]->academicYear->title}} </span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_school'):</span> 
            <span class="pdf-text-thin"> {{$alumn->academicYears[0]->classroom->scholarCenter ? $alumn->academicYears[0]->classroom->scholarCenter->name : ''}} </span>
        </li>
            <span class="pdf-text-bold">· @lang('messages.pdf_academic_year'):</span> 
            <span class="pdf-text-thin"> {{ $alumn->academicYears[0]->academicYear->title}} </span>
        </li>
        <li>
            <span class="pdf-text-bold">· @lang('messages.pdf_ul_evaluator'):</span> 
            <span class="pdf-text-thin"> {{ $alumn->academicYears[0]->tutor ? $alumn->academicYears[0]->tutor->name : '' }} </span>
        </li>
    </ul>
    @if($alumn->gender['id'] == 1)
        <img src="{{ $alumn->image ? $alumn->image->full_url : public_path() . '/images/alumns/pupil.png'}}" alt="Avatar del alumno." class="pdf-avatar">  
    @elseif($alumn->gender['id'] == 2)  
        <img src="{{ $alumn->image ? $alumn->image->full_url : public_path() . '/images/alumns/student.png'}}" alt="Avatar del alumno." class="pdf-avatar">
    @else
        <img src="{{ $alumn->image ? $alumn->image->full_url : public_path() . '/images/alumns/pupil.png'}}" alt="Avatar del alumno." class="pdf-avatar"> 
    @endif
</section>

<section>
    <div class="details">
        <div style="width: 300px">
            <p class="rubric-border" style="width: 300px">
                <span style="color: #03002D; padding-right: 10px;">@lang('messages.pdf_ul_qualification'): {{$qualification['qualification']-> qualificationItems[0]->evaluation->evaluation_grade}}
                @if($qualification['qualification']-> qualificationItems[0]->evaluation->evaluation_grade < 5)
                    <img src="{{ public_path() . '/images/test/face_very_bad.svg'}}" alt="Foto del resultado de la nota." style="width: 30px; height: 30px; position: relative; top: 7px;">
                    <span style="color: rgb(249, 47, 40); padding-left: 10px;">@lang('messages.rubric_result1') (1-4)</span>
                @elseif($qualification['qualification']-> qualificationItems[0]->evaluation->evaluation_grade >= 5 && $qualification['qualification']-> qualificationItems[0]->evaluation->evaluation_grade <= 6)  
                    <img src="{{ public_path() . '/images/test/face_regular.svg'}}" alt="Foto del resultado de la nota." style="width: 30px; height: 30px; position: relative; top: 7px;">
                    <span style="color: rgb(217, 241, 10); padding-left: 10px;">@lang('messages.rubric_result2') (5-6)</span>
                @elseif($qualification['qualification']-> qualificationItems[0]->evaluation->evaluation_grade > 6 && $qualification['qualification']-> qualificationItems[0]->evaluation->evaluation_grade <= 8)  
                    <img src="{{ public_path() . '/images/test/face_good.svg'}}" alt="Foto del resultado de la nota." style="width: 30px; height: 30px; position: relative; top: 7px;">
                    <span style="color: #0065e9; padding-left: 10px;">@lang('messages.rubric_result3') (7-8)</span>
                @elseif($qualification['qualification']-> qualificationItems[0]->evaluation->evaluation_grade > 8)
                    <img src="{{ public_path() . '/images/test/face_very_good.svg'}}" alt="Foto del resultado de la nota." style="width: 30px; height: 30px; position: relative; top: 7px;">
                    <span style="color: #00E9C5; padding-left: 10px;">@lang('messages.rubric_result4') (9-10)</span>
                @endif
            </p>
        </div>
    </div>
    <div class="competences" style="padding-bottom: 25px;">
        <span class="pdf-rubric-title">
            @lang('messages.pdf_degree_acquisition'):
        </span>
        <span class="pdf-competences">
            @for($i = 0; $i < count($competence); $i++)
                @php
                    $posicion_inicio = strpos($competence[$i]->competence_key, "(");
                    $posicion_fin = strpos($competence[$i]->competence_key, ")", $posicion_inicio);

                    $palabra = substr($competence[$i]->competence_key, $posicion_inicio + 1, $posicion_fin - $posicion_inicio - 1);
                @endphp

                <span style="font-size: 14px; color: #BCBABA">{{$competence[$i]->competence->acronym}}</span>
                <img  src="{{ public_path() . '/images/competences/' . $competence[$i]->competence->acronym . '.png'}}" alt="iamge competence" style="width: 20px; height: 20px; position: relative; top: 6px;" />
                <span style="font-size: 14px; color: #6F6F6F">{{$palabra}}</span>
            @endfor
        </span>
    </div>
    <div style="position: relative; right: 20px; width: 850px;">
        <table class="table-bar" aria-describedby="Tabla sobre las calificaciones de las rúbricas.">
            <thead>
                <tr>
                    <th id="rubrid-header">@lang('messages.rubric_header1')</th>
                    <th id ="percentage">%</th>
                    <th id="rubrid-header2">@lang('messages.rubric_header2')</th>
                    <th id="rubrid-header3">@lang('messages.rubric_header3')</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th id="name"> {{$qualification['qualification']-> qualificationItems[0]->rubric->name}} </th>
                    <th id="percentage"> {{$qualification['qualification']-> qualificationItems[0]->rubric->indicators[0]->percentage }} % </th>
                    <th id="evaluation-grade">
                        <span>
                            {{$qualification['qualification']-> qualificationItems[0]->evaluation->evaluation_grade}}
                        </span>
                        @if($qualification['qualification']-> qualificationItems[0]->evaluation->evaluation_grade < 5)         
                            <img src="{{ public_path() . '/images/test/face_very_bad.svg'}}" alt="Foto del resultado de la nota." style="width: 30px; height: 30px; position: relative; top: 7px;">
                            <span style="color: rgb(249, 47, 40); padding-left: 10px;">@lang('messages.rubric_result1') (1-4)</span>
                        @elseif($qualification['qualification']-> qualificationItems[0]->evaluation->evaluation_grade >= 5 && $qualification['qualification']-> qualificationItems[0]->evaluation->evaluation_grade <= 6)  
                            <img src="{{ public_path() . '/images/test/face_regular.svg'}}" alt="Foto del resultado de la nota." style="width: 30px; height: 30px; position: relative; top: 7px;">
                            <span style="color: rgb(217, 241, 10); padding-left: 10px;">@lang('messages.rubric_result2') (5-6)</span>
                        @elseif($qualification['qualification']-> qualificationItems[0]->evaluation->evaluation_grade > 6 && $qualification['qualification']-> qualificationItems[0]->evaluation->evaluation_grade <= 8)  
                            <img src="{{ public_path() . '/images/test/face_good.svg'}}" alt="Foto del resultado de la nota." style="width: 30px; height: 30px; position: relative; top: 7px;">
                            <span style="color: #0065e9; padding-left: 10px;">@lang('messages.rubric_result3') (7-8)</span>
                        @elseif($qualification['qualification']-> qualificationItems[0]->evaluation->evaluation_grade > 8)
                            <img src="{{ public_path() . '/images/test/face_very_good.svg'}}" alt="Foto del resultado de la nota." style="width: 30px; height: 30px; position: relative; top: 7px;">
                            <span style="color: #00E9C5; padding-left: 10px;">@lang('messages.rubric_result4') (9-10)</span>
                        @endif
                    </th>
                    <th id="competence">
                        @for($i = 0; $i < count($competence); $i++)
                            <img  src="{{ public_path() . '/images/competences/' . $competence[$i]->competence->acronym . '.png'}}" alt="image-competence" style="width: 20px; height: 20px; position: relative; top: 6px;" />
                        @endfor
                    </th>
                </tr>
            </tbody>
        </table>
    </div>
</section>

<div id="footer">
    <span style="padding-left: 15px;color: #03002D;letter-spacing: 5px;">@lang('messages.pdf_footer'): </span> {{ \Carbon\Carbon::now()->format('d/m/Y')}}
    <img src="{{ public_path() . '/images/pdf-bottom-banner.png'}}" alt="" style="left: 95px;" class="pdf-image-footer">
</div>
@endsection