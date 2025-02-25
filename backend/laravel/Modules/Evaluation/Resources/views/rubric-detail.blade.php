@extends('evaluation::layouts.master')

@section('content')

<section>
    <div class="pdf-title">
      @lang('messages.rubric_title')
    </div>
    

            <div class="pdf-full-name">
                {{ $alumn->full_name }}
            </div>

            <ul class="pdf-attributes">
                <li>
                   <span class="pdf-text-bold">· @lang('messages.pdf_ul_list_no'):</span> <span class="pdf-text-thin"> {{ $alumn->list_number }} </span>
                </li>
                <li>
                  <span class="pdf-text-bold">· @lang('messages.pdf_ul_classroom'):</span> <span class="pdf-text-thin"> {{ $alumn->academicYears[0]->academicYear->title }} </span>
               </li>
                <li>
                   <span class="pdf-text-bold">· @lang('messages.pdf_ul_school'):</span> <span class="pdf-text-thin"> {{ $alumn->academicYears[0]->classroom->scholarCenter ? $alumn->academicYears[0]->classroom->scholarCenter->name : '' }} </span>
                </li>
                <li>
                   <span class="pdf-text-bold">· @lang('messages.pdf_ul_date'):</span> <span class="pdf-text-thin"> 
                     
                     {{ $rubric->created_at ? $rubric->created_at->format('d/m/Y') : 'No date' }}
                  
                  </span>
                </li>
                <li>
                    <span class="pdf-text-bold">· @lang('messages.pdf_ul_num_evaluation'):</span> <span class="pdf-text-thin"> {{ $rubric->id }} </span>
                 </li>
                 <li>
                  <span class="pdf-text-bold">· @lang('messages.pdf_ul_school_period'):</span> <span class="pdf-text-thin"> {{ $alumn->academicYears[0]->academicYear->academicPeriods[$alumn->academicYears[0]->academicYear->academicPeriods->count() - 1]->title }} </span>
               </li>
                <li>
                   <span class="pdf-text-bold">· @lang('messages.pdf_ul_evaluator'):</span> <span class="pdf-text-thin"> {{ $alumn->academicYears[0]->tutor ? $alumn->academicYears[0]->tutor->name : '' }} </span>
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

<div class="details">
   <div class="pdf-rubric-title">
      {{ $rubric->name }}
   </div>

   <div class="pdf-calification">
      <p class="rubric-border"><span style="color: #03002D;">@lang('messages.pdf_ul_qualification'): </span>{{ $evaluation['score'] }}</p>
      
      <div class="rubric-result">
         @if($evaluation['score'] < 5)         
            <img src="{{ public_path() . '/images/test/face_very_bad.svg'}}" alt="Foto del resultado de la nota." class="pdf-image-result">
            <span style="color: rgb(249, 47, 40); font-family: Arial, Verdana, Tahoma, sans-serif;">@lang('messages.rubric_result1') (1-4)</span>
         @elseif($evaluation['score'] >= 5 && $evaluation['score'] <= 6)  
            <img src="{{ public_path() . '/images/test/face_regular.svg'}}" alt="Foto del resultado de la nota." class="pdf-image-result">
            <span style="color: rgb(217, 241, 10); font-family: Arial, Verdana, Tahoma, sans-serif;">@lang('messages.rubric_result2') (5-6)</span>
         @elseif($evaluation['score'] > 6 && $evaluation['score'] <= 8)  
            <img src="{{ public_path() . '/images/test/face_good.svg'}}" alt="Foto del resultado de la nota." class="pdf-image-result">
            <span style="color: #0065e9; font-family: Arial, Verdana, Tahoma, sans-serif;">@lang('messages.rubric_result3') (7-8)</span>
         @elseif($evaluation['score'] > 8)  
            <img src="{{ public_path() . '/images/test/face_very_good.svg'}}" alt="Foto del resultado de la nota." class="pdf-image-result">
            <span style="color: #00E9C5; font-family: Arial, Verdana, Tahoma, sans-serif;">@lang('messages.rubric_result4') (9-10)</span>
         @endif
      </div>

   </div>
</div>

<div>
   <table class="table-bar" aria-describedby="Tabla sobre las calificaciones de las rúbricas.">
      <thead>
         <tr>
            <th>@lang('messages.rubric_header1')</th>
            <th>%</th>
            <th>@lang('messages.rubric_header2')</th>
            <th>@lang('messages.rubric_header3')</th>
         </tr>
      </thead>
      <tbody>

         @foreach ($evaluation['grades'] as $grade)

            <tr>
               <td>{{ $grade->indicatorRubric->indicator->name }}</td>
               <td>{{ $grade->indicatorRubric->indicator->percentage }}%</td>
               <td>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;{{ $grade->grade }}
               
                  @if($grade->grade < 5)         
                     <img src="{{ public_path() . '/images/test/face_very_bad.svg'}}" alt="Foto del resultado de la nota." class="pdf-image">
                  @elseif($grade->grade >= 5 && $evaluation['score'] <= 6)  
                     <img src="{{ public_path() . '/images/test/face_regular.svg'}}" alt="Foto del resultado de la nota." class="pdf-image">
                  @elseif($grade->grade > 6 && $evaluation['score'] <= 8)  
                     <img src="{{ public_path() . '/images/test/face_good.svg'}}" alt="Foto del resultado de la nota." class="pdf-image">
                  @elseif($grade->grade > 8)  
                     <img src="{{ public_path() . '/images/test/face_very_good.svg'}}" alt="Foto del resultado de la nota." class="pdf-image">  
                  @endif
               
               </td>
               <td>

                  @if($grade->indicatorRubric->indicator->competences->count() > 0)         
                     @foreach ($grade->indicatorRubric->indicator->competences as $competence)
                        <img src="{{ public_path() . '/images/competences/' . $competence->acronym . '.png'}}" alt="Foto de la competencia." class="pdf-image">
                     @endforeach   
                  @else
                     No competences    
                  @endif
                  
               </td>
            </tr>

         @endforeach
      </tbody>
   </table>

   <div class="competences">
      <div class="pdf-rubric-title">
         @lang('messages.rubric_header4')
      </div>

      <div class="pdf-competences">

         @if($grade->indicatorRubric->indicator->competences->count() > 0)         
            @foreach ($evaluation['competences_score'] as $score)
            <div class="pdf-competences-items">
               <img src="{{ public_path() . '/images/competences/' . $score['competence']['acronym'] . '.png'}}" alt="Foto de la competencia." class="pdf-image-competences">

               @if($score['grade'] < 5)         
                  <span style="color: rgb(249, 47, 40); font-family: Arial, Verdana, Tahoma, sans-serif;">CEC</span>
                  <img src="{{ public_path() . '/images/test/face_very_bad.svg'}}" alt="Foto del resultado de la nota." class="pdf-image-competences">
               @elseif($score['grade'] >= 5)  
                  <span style="color: rgb(217, 241, 10); font-family: Arial, Verdana, Tahoma, sans-serif;">{{ $score['competence']['acronym'] }}</span>
                  <img src="{{ public_path() . '/images/test/face_regular.svg'}}" alt="Foto del resultado de la nota." class="pdf-image-competences">
               @elseif($score['grade'] > 6)  
                  <span style="color: #0065e9; font-family: Arial, Verdana, Tahoma, sans-serif;">{{ $score['competence']['acronym'] }}</span>
                  <img src="{{ public_path() . '/images/test/face_good.svg'}}" alt="Foto del resultado de la nota." class="pdf-image-competences">
               @elseif($score['grade'] > 8)  
                  <span style="color: #00E9C5; font-family: Arial, Verdana, Tahoma, sans-serif;">{{ $score['competence']['acronym'] }}</span>
                  <img src="{{ public_path() . '/images/test/face_very_good.svg'}}" alt="Foto del resultado de la nota." class="pdf-image-competences">
               @endif
            </div>
            @endforeach   
         @else
            <p class="pdf-text-thin">@lang('messages.pdf_no_competences')</p>
         @endif
      </div>
   </div>

</div>

<div class="pdf-date">
    <span style="padding-left: 15px;color: #03002D;letter-spacing: 5px;">@lang('messages.pdf_footer'): </span> {{ \Carbon\Carbon::now()->format('d/m/Y')}}
</div>

@endsection