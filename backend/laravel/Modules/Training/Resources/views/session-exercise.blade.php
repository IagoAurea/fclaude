@extends('training::layouts.master')

@section('content')
    <header style="position: fixed; top: -1px; left:0; right: 0; width: 100%;">
        <table aria-describedby="Table Header">
            <th></th>
            <tr>
                <!-- Section Team -->
                <td style="text-align: center; padding: 20px 35px 0px 35px; ">
                    <div>
                        <img src="{{ public_path() . '/images/images/club/club_example.png'}}" style="width: 80px; height: 100px;" alt="image-example"/>
                    </div>
                    <div style="text-align: center; font-family: Arial, Verdana, Tahoma, sans-serif; width: 200px; word-wrap: break-word; border: 3px solid #00e9c5; border-radius: 6px;color: #03002D;">
                        <span>Manchester United F.C</span>
                    </div>
                </td>
                <!-- End Section Team -->
                <!-- Section Session -->
                <td>
                    <div>
                        <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; border-bottom: 3px solid #00e9c5; font-size: 18px;">Sesión:</span> 
                        <span style="color: #03002D; font-size: 18px;">{{$session->title}}</span>
                    </div>
                    <table aria-describedby="First Column">
                        <th></th>
                        <tr>
                            <td style="padding-right: 40px;">
                                <span style="color: #00e9c5; font-size: 20px">-</span>
                                <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; font-size: 16px;">Fecha:</span>
                                @foreach($session->exercise_session_details as $item)
                                    <span style="color: #03002D; font-size: 16px;">{{$item->date_session}}</span>
                                @endforeach
                            </td>
                            <td>
                                <span style="color: #00e9c5;font-size: 20px">-</span>
                                <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; font-size: 16px;">Tipo de Sesión:</span>
                                <span style="color: #03002D; font-size: 16px;">
                                    {{$session->type_exercise_session->name}}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span style="color: #00e9c5;font-size: 20px">-</span>
                                <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; font-size: 16px;">Hora:</span>
                                @foreach($session->exercise_session_details as $item)
                                    <span style="color: #03002D; font-size: 16px;">{{$item->hour_session}}</span>
                                @endforeach
                            </td>
                            <td>
                                <span style="color: #00e9c5;font-size: 20px">-</span>
                                <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; font-size: 16px;">Periodo:</span>
                                <span style="color: #03002D; font-size: 16px;">{{$session->training_period->name}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span style="color: #00e9c5;font-size: 20px">-</span>
                                <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; font-size: 16px;">Lugar:</span>
                                @foreach($session->exercise_session_details as $item)
                                    <span style="color: #03002D; font-size: 16px;">{{$item->place_session}}</span>
                                @endforeach
                            </td>
                            <td>
                                <span style="color: #00e9c5;font-size: 20px">-</span>
                                <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; font-size: 16px;">Duracion:</span>
                                <span style="color: #03002D; font-size: 16px;">{{$session->duration}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span style="color: #00e9c5;font-size: 20px">-</span>
                                <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; font-size: 16px;">Proximo Rival:</span>
                                <span style="color: #03002D; font-size: 16px;">U.D LAS PALMAS</span>
                            </td>
                            <td>
                                <span style="color: #00e9c5;font-size: 20px">-</span>
                                <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; font-size: 16px;">Total de ejercicios:</span>
                                <span style="color: #03002D; font-size: 16px;">{{count($session->exercise_session_exercises)}}</span>
                            </td>
                        </tr>
                    </table>
                </td>
                <!-- End Section Session -->
                <!-- Section Contents -->
                <td style="">
                    <div>
                        <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; border-bottom: 3px solid #00e9c5; font-size: 18px;">Contenidos:</span> 
                    </div>
                    <table aria-describedby="Second Column">
                        <th></th>
                        <tr>
                            <td>
                                <span style="color: #00e9c5;font-size: 20px">-</span>
                                <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; font-size: 16px;">Hora:</span>
                            </td>
                        </tr>
                    </table>
                </td>
                <!-- End Section Contents -->
            </tr>
        </table>
        <!-- Section Info Difficult -->
        <div style="position: absolute; top: 5px; right: 35px;">
            <table aria-describedby="Table difficulty info">
                <th></th>
                <tr>
                    <td style="padding-right: 15px;">
                        <div>
                            <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; font-size: 18px;"> @lang('exercise::messages.difficulty'):</span>
                            @for($i = 0; $i < 5; $i++)
                                @if($session->difficulty <= $i )
                                    <img src="{{ public_path() . '/images/start-difficulty-incomplete.png'}}" alt="difficulty-incomplete" style=" width: 15px; padding-right: 8px">
                                    @else <img src="{{ public_path() . '/images/start-difficulty.png'}}" alt="start-difficulty" style=" width: 15px; padding-right: 8px">  
                                @endif
                            @endfor 
                        </div>
                    </td>
                    <td style="padding-right: 15px;">
                        <div style="text-align:center;">
                            <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; font-size: 18px;">@lang('exercise::messages.intensity'):</span>
                            @if($session->intensityRelation)
                                <img src="{{ $exercise->intensityRelation->image->full_url }}" alt="instensity-image" style="width:25px; height: 25px; position: relative; top: 7px;">
                                @else <span style="color: #03002D; font-size: 18px;">N/A</span>
                            @endif
                        </div>
                    </td>
                    <td style="padding-right: 15px;">
                        <div>
                            <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; font-size: 18px;">Asistencia</span>
                            <span style="color: #03002D; font-size: 18px;">24(23)</span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <!-- Section Info Difficult -->
        <!-- Section Info Materials and User -->
        <table style="margin-left: 35px;" aria-describedby="Table Material">
            <th></th>
            <tr>
                <td>
                    <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; font-size: 16px;">Categoria: </span>
                    <span>Prebenjamín </span>
                </td>
                <td style="width: 1050px;">
                    <img src="{{ public_path() . '/images/training_cone.png'}}" alt="training-cone" style=" width: 20px; position:relative;padding: 0px; margin:0px; left:8px;"> 
                    <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; font-size: 16px;">
                        @lang('exercise::messages.materials'):
                    </span>
                    <span class="width: 850px; position:relative; right: 20px; text-align: center; font-size: 16px; color: #03002D;">
                    @if(!$session->materials) 
                        <span style="color: #03002D; font-size: 16px;">@lang('exercise::messages.not_results_fount')</span>
                        @else
                            <span style="color: #03002D; font-size: 16px;">
                                @foreach($session->materials as $material)
                                    @foreach($material as $item) 
                                        @if($loop->index === 2)
                                            {{$item}},
                                        @endif
                                    @endforeach
                                @endforeach
                            </span>
                    @endif
                    </span>
                </td>
                <td>
                    <div style="color: #03002D">
                        <img src="{{ public_path() . '/images/logo_green.png'}}" alt="logo_green" style="width: 20px; height: 20px;"> 
                        <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; font-size: 16px;">
                            @lang('exercise::messages.create_user'): 
                        </span>
                        <span style="color: #03002D; font-size: 16px;">
                            {{ $session->author  }}
                        </span>
                    </div>
                </td>
            </tr>
        </table>
        <!-- End Section Info Materials and User -->
    </header>

    <footer style="position: fixed; left: 0px; right: 0px; bottom: -1px;  font-family: 'cooper-hewitt-bold'; color: #00e9c5; width: 100%;">
        <img src="{{ public_path() . '/images/pdf-banner.png'}}" alt="" style="width: 500px; margin-left: 20px; height: 50px;">
        <span>
            <span style="padding-left:553px;width: 100%;">
                <span style="padding-right: 15px;color: #00e9c5; font-size: 20px;">
                    @lang('exercise::messages.exercise_generated')
                </span>
                <img src="{{ public_path() . '/images/pdf-bottom-banner.png'}}" style="width: 300px; position:relative; top: 10px; right: -1px;" alt="bottom-banner">
            </span>
        </span>
    </footer>
    <!-- Section Exercise Info -->
    <section">
        @foreach($session->exercise_session_exercises as $session)
            <table aria-describedby="Table Exercise" style="margin-left: 25px; border-left: 3px solid #00e9c5;border-right: 3px solid #00e9c5; border-top: 1.5px solid #00e9c5;border-bottom: 1.5px solid #00e9c5; padding: 0;" cellspacing="0" cellpadding="0">
                <th></th>
                <td style="border-right: 3px solid #00e9c5; width: 965px;">
                    <table style="width: 965px;" aria-describedby="Table Exercise Info">
                            <td style="width:400px;">
                                <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; border-bottom: 3px solid #00e9c5; font-size: 18px;">Ejercicio {{$loop->iteration}}:</span> 
                                <span style="color: #03002D; font-size: 18px;">{{$session->exercise->title}}</span>
                            </td>
                            <td style="padding-right: 15px;">
                                <div>
                                    <span class="pdf-subtitle-header">@lang('exercise::messages.difficulty'):</span>
                                    @for($i = 0; $i < 5; $i++)
                                        @if($session->difficulty <= $i )
                                            <img src="{{ public_path() . '/images/start-difficulty-incomplete.png'}}" alt="difficulty-incomplete" style=" width: 15px; padding-right: 8px">
                                            @else <img src="{{ public_path() . '/images/start-difficulty.png'}}" alt="start-difficulty" style=" width: 15px; padding-right: 8px">  
                                    @endif
                                    @endfor 
                                </div>
                            </td>
                            <td style="padding-right: 15px;">
                                <div style="text-align:center;">
                                    <span class="pdf-subtitle-header">@lang('exercise::messages.intensity'):</span>
                                    @if($session->intensityRelation)
                                        <img src="{{ $exercise->intensityRelation->image->full_url }}" alt="image instensiy" style="width:25px; height: 25px; position: relative; top: 7px;">
                                        @else <span class=" color: #03002D; font-size: 18px;  padding-left:8px;">N/A</span>
                                    @endif
                                </div>
                            </td>
                            <td style="padding-right: 15px;">
                                <div>
                                    <span class="pdf-subtitle-header pdf-underline">
                                        @lang('exercise::messages.duration'):
                                    </span>
                                    {{ $session->duration }} min.
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table aria-describedby="Table Repetitions Info">
                        <th></th>
                        <tr>
                            <td style="width: 230px;">
                                <span style="color: #00e9c5; font-size: 20px">-</span>
                                <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; font-size: 16px;">Repeticiones:</span>
                                <span style="color: #03002D; font-size: 18px;">{{ $session->exercise->repetitions }} rep</span>
                            </td>
                            <td style="width: 260px;">
                                <span style="color: #00e9c5; font-size: 20px">-</span>
                                <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; font-size: 16px;">Descanso Repeticiones:</span>
                                <span style="color: #03002D; font-size: 18px;">{{ $session->exercise->break_repetitions }} sg.</span>
                            </td>
                            <td style="width: 215px;">
                                <span style="color: #00e9c5; font-size: 20px">-</span>
                                <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; font-size: 16px;">Series:</span>
                                <span style="color: #03002D; font-size: 18px;">{{ $session->exercise->series }}</span>
                            </td>  
                            <td style="width: 215px;">
                                <span style="color: #00e9c5; font-size: 20px">-</span>
                                <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; font-size: 16px;">Descanso Series:</span>
                                <span style="color: #03002D; font-size: 18px;">{{$session->exercise->break_series}}</span>
                            </td>
                        </tr>
                    </table>
                    <div style="width: 100%; ">
                        <span style="color: #00e9c5; font-size: 20px">-</span>
                        <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; font-size: 16px;">Descripcion:</span>
                        <span style="color: #03002D; font-size: 18px;">{{$session->exercise->description}}</span>
                    </div>
                    <table aria-describedby="Table Dimensions and Type Work">
                        <th></th>
                        <tr>
                            <td>
                                <span style="color: #00e9c5; font-size: 20px">-</span>
                                <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; font-size: 16px;">Dimensiones del terreno de juego:</span>
                                <span style="color: #03002D; font-size: 18px;">{{$session->exercise->dimensions}}</span>
                            </td>
                            <td>
                                <span style="color: #00e9c5; font-size: 20px">-</span>
                                <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; font-size: 16px;">Distribución / Tipo de trabajo:</span>
                                <span style="color: #03002D; font-size: 18px;">{{$session->exercise->type_work}}</span>
                            </td>
                        </tr>
                    </table>
                    <div style="min-height: 250px;">
                        <div style="padding-left: 10px">
                            <img src="{{ public_path() . '/images/work_group.png'}}" alt="work-group" style=" width: 15px; position:relative;padding: 0px; margin:0px;"> 
                            <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; font-size: 16px;">Grupos de trabajo:</span>
                        </div>
                        @for($i = 0; $i < 5; $i++)
                            <div>
                                <span style="color: #00e9c5; font-size: 20px">-</span>
                                <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; font-size: 16px;">Grupo {{$i+1}}</span>
                                <span style="color: #03002D; font-size: 18px;">Carlos, Raul, Alejandro, Javier, Eduardo, Mané, Alfonso, Carlos, Raul, Alejandro, Javier, Eduardo</span>
                            </div>
                        @endfor  
                    </div>
                </td>
                <td>
                    <div style="">
                        @if($session->exercise->image) 
                            <img src="{{ $session->exercise->image->full_url }}" alt="image-exercise" style="padding: 4px; width: 520px; height: 400px;">
                        @else
                            <img src="{{ $session->exercise->sport->imageExercise->full_url }}" alt="image-sport" style="padding: 4px; width: 520px; height: 400px;">
                        @endif
                    </div>
                </td>  
            </table>
        @endforeach
        <div style="page-break-before: always;"></div>
    </section>
    <!-- End Section Exercise Info -->
    <!-- Section Observations -->
    <section>
        <div style="border: 3px solid #00e9c5; margin-left: 20px; margin-right: 25px; min-height: 800px;">
            <table style="margin: 10px 20px 0 20px;" aria-describedby="Table Session Absentees">
                <th></th>
                <tr>
                    <td style="width: 230px;">
                        <img src="{{ public_path() . '/images/work_group.png'}}" alt="work-group" style=" width: 15px; position:relative;padding: 0px; margin:0px;"> 
                        <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; border-bottom: 3px solid #00e9c5; font-size: 18px;">
                            Ausentes en la sesion:
                        </span>
                    </td>
                    <td style="display: inline-block;">
                        @for($i = 0; $i < 11; $i++)
                            <span style="display: inline-block; padding-right: 15px; ">
                                <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #00e9c5; font-size: 18px;">10</span>
                                <img src="{{ public_path() . '/images/logo.png'}}" alt="logo" style="width: 20px; height: 20px; border-radius: 100%; background-color: red;" />
                                <span style="color: #03002D; font-size: 18px;">Carlos Zambrano</span>
                            </span>
                        @endfor
                    </td>
                </tr>
            </table>
            <div>
                <div style="margin: 0px 20px;">
                    <img src="{{ public_path() . '/images/icons-eye.png'}}" alt="icons-eye" style="width: 20px; height: 20px;" />
                    <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; border-bottom: 3px solid #00e9c5; font-size: 18px;">
                        Observaciones: 
                    </span>
                </div>
                <div style="margin: 0px 20px;">
                    <p style="color: #03002D; font-size: 18px;">
                        Es una actividad planificada, estructurada y repetitiva, cuyo fin es mantener y mejorar nuestra forma física; entendiendo por forma física el nivel de energía y vitalidad que nos permite llevar a cabo las tareas cotidianas
                        habituales, disfrutando activamente de nuestro ocio, disminuyendo las enfermedades derivadas de la falta de actividad física y desarrollando al máximo nuestra capacidad intelectual. Es una actividad planificada,
                        estructurada y repetitiva, cuyo fin es mantener y mejorar nuestra forma física; entendiendo por forma física el nivel de energía y vitalidad que nos permite llevar a cabo las pone forma física el nivel de energía y vitalidad
                        que nos permite llevar a cabo las tareas cotidianas habituales, disfrutando activamente de nuestro ocio, disminuyendo las enfermedades derivadas de la falta de actividad física y desarrollando al máximo nuestra
                        capacidad intelectual. Es una actividad planificada, estructurada y repetitiva, cuyo fin es mantener y mejorar nuestra forma física; entendiendo por forma física el nivel de energía y vitalidad que nos permite llevar a cabo
                        las tar
                    </p>
                </div>
            </div>
            <div>
                <div style="margin: 0px 20px;">
                    <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #03002D; border-bottom: 3px solid #00e9c5; font-size: 18px;">
                        RPE (Percepcion subjetiva del esfuerzo): 
                    </span>
                </div>
                <table style="margin: auto;" aria-describedby="Table Alumn Session">
                    <th></th>
                    @for($i = 0; $i < 20; $i++)
                        @if(($i % 6) == 0 )
                            <tr></tr>
                        @endif
                        <td style="padding-right: 50px;">
                            <div style="display: inline-block; padding-right: 15px; ">
                                <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #00e9c5; font-size: 18px;">10</span>
                                <img src="{{ public_path() . '/images/logo.png'}}" alt="logo" style="width: 20px; height: 20px; border-radius: 100%; background-color: red;" />
                                <span style="color: #03002D; font-size: 18px;">Carlos Zambrano</span>
                            </div>
                        </td>
                    @endfor
                </table>
            </div>
        </div>
    </section>
    <!-- End Section Observations -->
    <!-- Section Heart Frequency -->
    <section>
        <div style="border: 3px solid #00e9c5; margin-left: 20px; margin-right: 25px; min-height: 800px;">
            <div style="text-align: center; font-size: 25px; color: #03002D;font-family: Arial, Verdana, Tahoma, sans-serif; border-bottom: 3px solid #00e9c5;">
                <img src="{{ public_path() . '/images/heart_cardiac.jpg'}}" alt="heart-cadiac" style="width: 35px; height: 35px; position: relative; top: 3px;" />
                <span>Frecuencia Cardiaca</span>
            </div>
            <table style="margin: 0px; padding: 0px; width: 100%;" cellspacing="0" cellpadding="0" aria-describedby="Table Frequency Cardiac">
                <th></th>
                <tbody>
                    <tr>
                        <td style="border-right: 3px solid #00e9c5;margin: 0px; width: 500px;">
                            <table style="height: 800px; " cellspacing="0" cellpadding="0" aria-describedby="Table Frequency Cardiac Info Left">
                                    <th></th>
                                    <tr style="font-size: 12px;font-family: Arial, Verdana, Tahoma, sans-serif;  ">
                                        <td style="width: 200px;"></td>
                                        <td style="background-color: #03002D;color: #fff; width: 105px; padding: 10px 0px 10px 20px;">
                                            <span style="border-bottom: 1.5px solid #00e9c5;">FC maxima</span>
                                        </td>
                                        <td style="background-color: #03002D;color: #fff; width: 105px; padding: 10px 0px;">
                                            <span style="border-bottom: 1.5px solid #00e9c5;">FC media</span>
                                        </td>
                                        <td style="background-color: #03002D;color: #fff; width: 105px; padding: 10px 0px;">
                                            <span style="border-bottom: 1.5px solid #00e9c5;">FC minima</span>
                                        </td>
                                        <td style="background-color: #03002D;color: #fff; width: 105px; padding: 10px 0px;">
                                            <span style="border-bottom: 1.5px solid #00e9c5;">Variabilidad FC</span>
                                        </td>
                                        <td style="background-color: #03002D;color: #fff; width: 105px; padding: 10px 0px; ">
                                            <span style="border-bottom: 1.5px solid #00e9c5;">VO2 maximo</span>
                                        </td>
                                    </tr>
                                    @for($i = 0; $i < 50; $i++)
                                        @if(($i % 2) == 0)
                                            <tr style="height:15px;">
                                                <td style="width: 107px">
                                                    <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #00e9c5; font-size: 18px;">10</span>
                                                    <img src="{{ public_path() . '/images/logo.png'}}" alt="logo" style="width: 20px; height: 20px; border-radius: 100%; background-color: red;" />
                                                    <span style="color: #03002D;">Carlos Zambrano</span>
                                                </td>
                                                <td style="width: 107px">
                                                    <span style="color: #03002D">180 ppm</span>
                                                </td>
                                                <td style="width: 107px">
                                                    <span style="color: #03002D">180 ppm</span>
                                                </td>
                                                <td style="width: 107px">
                                                    <span style="color: #03002D">134 ppm</span>
                                                </td>
                                                <td style="width: 107px">
                                                    <span style="color: #03002D">857 ms </span>
                                                </td>
                                                <td style="width: 107px">
                                                    <span style="color: #03002D">55,7 ml/kg/min </span>
                                                </td>
                                            </tr>
                                        @endif
                                    @endfor
                            </table>
                        </td>
                        <td style="margin: 0px; width: 500px; ">
                            <table style="padding-right: 30px; height: 800px;" cellspacing="0" cellpadding="0" aria-describedby="Table Frequency Cardiac Info Right">
                                <th></th>
                                    <tr style="font-size: 12px;font-family: Arial, Verdana, Tahoma, sans-serif;">
                                        <td style="width: 210px;"></td>
                                        <td style="background-color: #03002D;color: #fff; width: 107px; padding: 10px 0px 10px 13px;">
                                            <span style="border-bottom: 1.5px solid #00e9c5;">FC maxima</span>
                                        </td>
                                        <td style="background-color: #03002D;color: #fff; width: 107px; padding: 10px 0px;">
                                            <span style="border-bottom: 1.5px solid #00e9c5;">FC media</span>
                                        </td>
                                        <td style="background-color: #03002D;color: #fff; width: 107px; padding: 10px 0px;">
                                            <span style="border-bottom: 1.5px solid #00e9c5;">FC minima</span>
                                        </td>
                                        <td style="background-color: #03002D;color: #fff; width: 107px; padding: 10px 0px;">
                                            <span style="border-bottom: 1.5px solid #00e9c5;">Variabilidad FC</span>
                                        </td>
                                        <td style="background-color: #03002D;color: #fff; width: 109px; padding: 10px 0px;">
                                            <span style="border-bottom: 1.5px solid #00e9c5;">VO2 maximo</span>
                                        </td>
                                    </tr>
                                    @for($i = 0; $i < 50; $i++)
                                        @if(($i % 2) !== 0)
                                            <tr style="height:15px;">
                                                <td style="width: 107px">
                                                    <span style="font-family: Arial, Verdana, Tahoma, sans-serif; color: #00e9c5; font-size: 18px;">10</span>
                                                    <img src="{{ public_path() . '/images/logo.png'}}" alt="logo" style="width: 20px; height: 20px; border-radius: 100%; background-color: red;" />
                                                    <span style="color: #03002D;">Carlos Zambrano</span>
                                                </td>
                                                <td style="width: 107px">
                                                    <span style="color: #03002D">180 ppm</span>
                                                </td>
                                                <td style="width: 107px">
                                                    <span style="color: #03002D">180 ppm</span>
                                                </td> 
                                                <td style="width: 107px">
                                                    <span style="color: #03002D">134 ppm</span>
                                                </td>
                                                <td style="width: 107px">
                                                    <span style="color: #03002D">857 ms </span>
                                                </td>
                                                <td style="width: 109px">
                                                    <span style="color: #03002D">55,7 ml/kg/min </span>
                                                </td>
                                            </tr>
                                        @endif
                                    @endfor
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
    <!-- End Section Heart Frequency -->
@endsection 