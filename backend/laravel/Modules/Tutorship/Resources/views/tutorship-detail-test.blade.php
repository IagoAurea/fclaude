@extends('tutorship::layouts.master')

@section('content')

<section>
    <div class="pdf-title" style="font-family: Arial, Verdana, Tahoma, sans-serif;">
      HOLA, ESTE PDF NO TIENE TRADUCCION
    </div>
         <div class="pdf-full-name" style="font-family: Arial, Verdana, Tahoma, sans-serif;">
               {{ $data->alumn->full_name }}
         @if($data->alumn->gender['id'] == 1)         
            <img src="{{ $data->alumn->image ? $data->alumn->image->full_url : public_path() . '/images/alumns/pupil.png'}}" alt="Avatar del alumno." class="pdf-avatar">  
         @elseif($data->alumn->gender['id'] == 2)  
            <img src="{{ $data->alumn->image ? $data->alumn->image->full_url : public_path() . '/images/alumns/student.png'}}" alt="Avatar del alumno." class="pdf-avatar">
         @else
            <img src="{{ $data->alumn->image ? $data->alumn->image->full_url : public_path() . '/images/alumns/pupil.png'}}" alt="Avatar del alumno." class="pdf-avatar"> 
         @endif
</section>

@endsection